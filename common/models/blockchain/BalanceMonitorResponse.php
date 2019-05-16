<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.07.17
 * Time: 1:36
 */

namespace common\models\blockchain;


use yii\base\Model;


class BalanceMonitorResponse extends Model
{
    public $transaction_hash;

    public $address;

    public $confirmations;

    public $value;


    public function rules()
    {
        return [
            [['value', 'confirmations', 'address', 'transaction_hash'], 'required']
        ];
    }
}