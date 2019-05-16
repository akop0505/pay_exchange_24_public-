<?php

namespace backend\modules\bestchange\models;

use backend\modules\bestchange\rates\Rate;
use common\models\Directions;
use Yii;

/**
 * This is the model class for table "monitor_bestchange".
 *
 * @property integer $id
 * @property integer $direction_id
 * @property integer $limit_min
 * @property integer $limit_max
 * @property integer $current_position
 * @property integer $target_position
 * @property integer $total_positions
 * @property integer $monitor_from_id
 * @property integer $monitor_to_id
 * @property string $monitor_direction_url
 * @property integer $updated_at
 *
 * @property Directions $direction
 */
class MonitorDirection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitor_bestchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['limit_min', 'limit_max'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '.', $value);
            }],

            [['direction_id', 'monitor_from_id', 'monitor_to_id'], 'required'],
            [['direction_id', 'current_position', 'target_position', 'total_positions', 'monitor_from_id', 'monitor_to_id', 'updated_at'], 'integer'],
            [['limit_min', 'limit_max'], 'number'],
            [['monitor_direction_url'], 'string', 'max' => 255],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Directions::className(), 'targetAttribute' => ['direction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'direction_id' => 'Direction ID',
            'limit_min' => 'Limit Min',
            'limit_max' => 'Limit Max',
            'current_position' => 'Current Position',
            'target_position' => 'Target Position',
            'total_positions' => 'Total Positions',
            'monitor_from_id' => 'Monitor From ID',
            'monitor_to_id' => 'Monitor To ID',
            'monitor_direction_url' => 'Monitor Direction Url',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return Rate
     */
    public function getCurrentRate()
    {
        $direction = $this->direction;

        $rate = $direction->d_out > 1 ? 1 / $direction->d_out : $direction->d_in;

        return new Rate($direction, $rate);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(Directions::className(), ['id' => 'direction_id']);
    }
}
