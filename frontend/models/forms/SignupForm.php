<?php

namespace frontend\models\forms;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $passwordConfirm;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь уже существует.'],

            ['password', 'required',],
            ['password', 'string', 'min' => 8],

            ['passwordConfirm', 'required'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new User();
        $user->username = $this->email;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        \Yii::$app->session->set('pass', $this->password);
        return $user->save() ? $user : null;
    }


    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
	
        if (!$user) {
            return false;
        }

        return \Yii::$app
            ->mailer
            ->compose(
                ['html' => 'registration-html', 'text' => 'registration-html'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => ' ' . \Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Регистрация аккаунта - ' . \Yii::$app->name)
            ->send();
    }
}
