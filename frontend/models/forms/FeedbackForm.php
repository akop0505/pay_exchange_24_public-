<?php

namespace frontend\models\forms;

use frontend\models\Feedback;
use yii\base\Model;

class FeedbackForm extends Model
{
    public $name;
    public $text;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['name', 'text'], 'string'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'text' => 'Текст отзыва',
        ];
    }

    public function createFeedback()
    {
        $model = new Feedback();
        $model->name = $this->name;
        $model->text = $this->text;
        $model->save();
    }
}
