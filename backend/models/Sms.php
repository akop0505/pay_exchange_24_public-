<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sms_log".
 *
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $body
 * @property string $date
 */
class Sms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'body'], 'required'],
            [['body'], 'string'],
            [['date','name'], 'safe'],
            [['number', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'name' => 'Name',
            'body' => 'Body',
            'date' => 'Date',
        ];
    }
}
