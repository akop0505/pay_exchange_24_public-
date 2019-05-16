<?php

namespace frontend\models\exchange;


use frontend\models\Bids;
use yii\base\Model;
use yii\bootstrap\Html;

abstract class ExchangeCurrency extends Model
{
    abstract public function render();

    abstract public function map(Bids $bid);


    protected function renderField($attribute, $options = [])
    {
        $label = Html::activeLabel($this, $attribute);
        $input = Html::activeTextInput($this, $attribute, $options);

        $str = '<div class="input-field">
                    ' . $input . $label . '
                    
                    <div class="error-keeper">Error</div>
                </div>';


        return $str;
    }
}