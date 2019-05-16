<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tokens".
 *
 * @property integer $id
 * @property string $access_token
 * @property string $refresh_token
 */
class Tokens extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tokens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_token', 'refresh_token'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
        ];
    }
}
