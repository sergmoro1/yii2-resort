<?php
namespace sergmoro1\resort\controllers;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use sergmoro1\modal\controllers\ModalController;
use sergmoro1\resort\models\Price;
use sergmoro1\resort\models\PriceSearch;
use sergmoro1\lookup\models\Lookup;

class PriceController extends ModalController
{
    public $modelName = 'Price';
    public function newModel() { return new Price(); }
    public function newSearch() { return new PriceSearch(); }

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
     * Fill in some fields by the last one values.
     * @param object $model
     * @param boolean $update
     * @return filled in model
     */
    public function fillin($model, $update = true)
    {
        if(!$update) {
            $last = Price::find()->orderBy(['id' => SORT_DESC])->one();
            foreach($model->accommodations as $accomodation) {
                $a[$accomodation->position] = $accomodation->code;
            }
            if($last && $last->position < count($a)) {
                $model->position = $last->position + 1;
                $model->type = $last->type;
                $model->fund_id = $last->fund_id;
                $model->accommodation = $a[$model->position];
                $model->food = $last->food;
                $model->treatment = $last->treatment;
            }
        }
        return $model;
    }

    /**
     * Finds model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Price::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEntityExists($type, $fund_id, $accommodation, $food, $treatment)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Price::find()->where([
            'type' => $type, 
            'fund_id' => $fund_id, 
            'accommodation' => $accommodation, 
            'food' => $food, 
            'treatment' => $treatment,
        ])->exists();
    }
}
