<?php

namespace backend\models;

use common\models\Income;
use common\models\Request;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;

class AccountingFilter extends Model
{
    public $dateFrom;

    public $dateTo;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'safe'],

            [['dateFrom'], 'filter', 'filter' => function ($value) {
                $date = \DateTime::createFromFormat('d.m.Y', $value);
                if ($date) {
                    return $date->format('Y-m-d 00:00:00');
                }
                return $value;
            }],

            [['dateTo'], 'filter', 'filter' => function ($value) {
                $date = \DateTime::createFromFormat('d.m.Y', $value);
                if ($date) {
                    return $date->format('Y-m-d 23:59:59');
                }
                return $value;


            }],
        ];
    }

    public function init()
    {
        parent::init();

        $this->load(Yii::$app->request->post());
        $this->validate();
        $this->clearErrors();
    }

    /**
     * @return ActiveQuery
     */
    public function getQuery()
    {
        $query = Income::find()->joinWith('request')->orderBy(Request::tableName() . '.created_at DESC');

        if ($this->dateFrom) {
            $query->andWhere(['>=', Request::tableName() . '.created_at', $this->dateFrom]);
        }

        if ($this->dateTo) {
            $query->andWhere(['<=', Request::tableName() . '.created_at', $this->dateTo]);
        }

        return $query;
    }
}
