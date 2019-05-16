<?php

namespace common\models;

use common\services\CurrenciesService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "exg_statistics".
 *
 * @property integer $id
 * @property string $event
 * @property string $cur_source
 * @property string $cur_dest
 * @property integer $data_1
 * @property string $data_2
 * @property integer $user_id
 * @property integer $created_at
 */
class Statistics extends \yii\db\ActiveRecord
{
    protected $curList = null;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exg_statistics';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'cur_source', 'cur_dest'], 'required'],
            [['cur_source', 'cur_dest'], 'in', 'range' => ArrayHelper::map(CurrenciesService::create()->getCurrencies(), 'id', 'send')],

            [['data_1', 'user_id', 'created_at'], 'integer'],
            [['event', 'data_2'], 'string', 'max' => 255],
            [['cur_source', 'cur_dest'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'cur_source' => 'Cur Source',
            'cur_dest' => 'Cur Dest',
            'data_1' => 'Data 1',
            'data_2' => 'Data 2',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
}
