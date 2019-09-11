<?php

namespace sergmoro1\resort\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PriceSearch extends Price
{
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['id', 'fund_id', 'type', 'food', 'accommodation'], 'integer'],
            ['treatment', 'boolean'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Price::find()
            ->innerJoin('fund', 'price.fund_id = fund.id')
            ->orderBy([
                'price.type' => SORT_ASC,
                'fund.hotel_id' => SORT_ASC, 
                'fund.category' => SORT_ASC, 
                'fund.room' => SORT_ASC, 
                'fund.person' => SORT_ASC, 
                'fund.size' => SORT_DESC, 
                'price.fund_id' => SORT_ASC, 
                'price.accommodation' => SORT_ASC, 
                'price.food' => SORT_ASC, 
                'price.treatment' => SORT_ASC, 
                'price.position' => SORT_ASC, 
                'price.value' => SORT_DESC,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['recordsPerPage'],
            ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['fund_id' => $this->fund_id])
            ->andFilterWhere(['food' => $this->food])
            ->andFilterWhere(['treatment' => $this->treatment])
            ->andFilterWhere(['accommodation' => $this->accommodation]);

        return $dataProvider;
    }
}
