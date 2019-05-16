<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shedule".
 *
 * @property integer $id
 * @property string $mode
 * @property string $time_start
 * @property string $time_end
 * @property integer $enabled
 */
class Shedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_start', 'time_end'], 'safe'],
            [['enabled'], 'integer'],
            [['mode'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode' => 'Mode',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'enabled' => 'Enabled',
        ];
    }
}
