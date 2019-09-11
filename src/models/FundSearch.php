<?php

namespace sergmoro1\resort\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Fund;

class FundSearch extends Fund
{
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['id', 'hotel_id', 'category', 'room', 'person'], 'integer'],
            ['caption', 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Fund::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['postsPerPage'],
            ],
            'sort' => [
                'defaultOrder' => [
                    'hotel_id' => SORT_ASC, 
                    'category' => SORT_ASC, 
                    'caption' => SORT_ASC,
                ]
            ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['room' => $this->room])
            ->andFilterWhere(['person' => $this->person])
            ->andFilterWhere(['hotel_id' => $this->hotel_id])
            ->andFilterWhere(['category' => $this->category])
            ->andFilterWhere(['like', 'caption', $this->caption]);

        return $dataProvider;
    }
}
