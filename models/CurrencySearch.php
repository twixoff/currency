<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class CurrencySearch extends Currency
{
    
    public $start_date;
    public $end_date;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['valuteID', 'numCode', 'сharCode', 'name', 'value'], 'safe'],
            [['date', 'start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Currency::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'valuteID', $this->valuteID])
            ->andFilterWhere(['like', 'numCode', $this->numCode])
            ->andFilterWhere(['like', 'сharCode', $this->сharCode])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['between', 'date', $this->start_date, $this->end_date]);

        return $dataProvider;
    }
}
