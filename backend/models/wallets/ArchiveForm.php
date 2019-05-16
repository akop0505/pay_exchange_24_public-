<?php

namespace backend\models\wallets;

use common\models\enum\RequestStatus;
use common\models\Income;
use common\models\Request;
use Yii;
use yii\base\Model;

class ArchiveForm extends Model
{
    public $newWalletId;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newWalletId'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'comment' => 'Новый активный кошелек',
        ];
    }
}
