<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "directions".
 *
 * @property integer $id
 * @property string $d_from
 * @property string $d_to
 * @property double $d_in
 * @property double $d_out
 * @property string $description
 * @property integer $price_id
 */
class Directions extends \common\models\Directions
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'directions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['d_in', 'd_out'], 'number'],
            [['description'], 'string'],
            [['price_id'], 'integer'],
            [['d_from', 'd_to'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'd_from' => 'D From',
            'd_to' => 'D To',
            'd_in' => 'D In',
            'd_out' => 'D Out',
            'description' => 'Description',
            'price_id' => 'Price ID',
        ];
    }
}
