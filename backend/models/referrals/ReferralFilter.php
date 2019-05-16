<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26.09.17
 * Time: 4:54
 */

namespace backend\models\referrals;


use common\models\Referrals;
use yii\base\Model;


class ReferralFilter extends Model
{
    public $id;


    public function rules()
    {
        return [
            [['id'], 'required']
        ];
    }

    public function getModel()
    {
        return Referrals::findOne(['id' => $this->id]);
    }
    public function afterValidate()
    {
        $this->clearErrors();
    }
}