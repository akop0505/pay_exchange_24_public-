<?php

namespace backend\models;

use kartik\daterange\DateRangeBehavior;
use yii\data\ActiveDataProvider;

class SmsSearch extends Sms
{

	public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }

    public function rules()
    {
        return [
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function search($params)
    {
        $query = Sms::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
            	'attributes' => ['name','number', 'body','date'],
            	'defaultOrder'=>['date'=>SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
		if (isset($this->createTimeStart) && isset($this->createTimeEnd)) {
			$query->andFilterWhere(['between', 'date', 
				date("Y-m-d h:i:s", $this->createTimeStart),
				date("Y-m-d h:i:s", $this->createTimeEnd)]);
		}
        return $dataProvider;
    }
}
