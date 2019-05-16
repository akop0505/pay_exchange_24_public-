<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.07.17
 * Time: 1:36
 */

namespace frontend\models\stats;


use yii\base\Model;

class Visit extends Model
{
    public $utmSrc;

    public $curFrom;

    public $curTo;


    public function rules()
    {
        return [
            [['utmSrc', 'curFrom', 'curTo'], 'required']
        ];
    }
}