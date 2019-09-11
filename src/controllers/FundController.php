<?php
namespace sergmoro1\resort\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

use common\models\Fund;
use sergmoro1\resort\models\FundSearch;

/**
 * FundController implements the CRUD actions for Fund model.
 */
class FundController extends Controller
{
    private $_model;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('index'))
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));

        $searchModel = new FundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Fund model.
     * @param integer $id
     * @param string $slug
     * @return mixed
     */
    public function actionView($id = 0, $slug= '')
    {
        $model = $this->loadModel($id, $slug);
        if (\Yii::$app->user->can('viewFund', ['fund' => $model])) {
            return $this->render('view', [
                'model' => $model,
            ]);
        } else
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));
    }

    /**
     * Creates a new Fund model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('create')) {
            $model = new Fund();
            
            $model->tv = $model->restroom = $model->room_service = $model->room_cleaning = true;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));
    }

    /**
     * Updates an existing Fund model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (\Yii::$app->user->can('update', ['fund' => $model])) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else
            throw new ForbiddenHttpException(\Yii::t('app', 'Access denied'));
    }

    /**
     * Deletes an existing Fund model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete')) {
            $model = $this->loadModel($id);
            foreach($model->files as $file)
                $file->delete();
            Yii::$app->db
                ->createCommand('DELETE FROM {{%comment}} WHERE model=:model AND parent_id=:parent_id')
                ->bindValues([':model' => Fund::COMMENT_FOR, ':parent_id' => $id])
                ->execute();

            $model->delete();

            return $this->redirect(['index']);
        } else
            throw new ForbiddenHttpException(\Yii::t('app', 'Access denied'));
    }

    /**
     * Finds the Fund model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function loadModel($id, $slug = '')
    {
        if($this->_model === null) 
        {
            if(($this->_model = $id ? Fund::findOne($id) : Fund::findOne(['slug' => $slug])) !== null) 
            {
                return $this->_model;
            } else {
                throw new NotFoundHttpException('The requested model does not exist.');
            }
        }
    }
}
