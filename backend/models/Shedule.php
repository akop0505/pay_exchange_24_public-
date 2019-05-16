<?php

namespace backend\models;

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
    private $_modes = [
        1 => 'auto',
        2 => 'online',
        3 => 'offline'
    ];


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

    public function getCurrent()
    {
        return Shedule::find()->where(['enabled'=>1])->one();
    }

    public function setMode($mode)
    {

        if (isset($this->_modes[$mode])) {

            Shedule::updateAll(['enabled'=>0]);
            $record = Shedule::find()->where(['mode' => $this->_modes[$mode]])->one();
            if (!$record) {
                return;
            }

            $record->enabled = 1;
            $record->save();
        }

        return;
    }
}
