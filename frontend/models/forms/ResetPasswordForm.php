<?php

namespace frontend\models\forms;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

class ResetPasswordForm extends Model
{
    public $passwordConfirm;
    public $password;

    /**
     * @var User
     */
    private $_user;

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'passwordConfirm' => 'Повторите пароль',
        ];
    }

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Токен сброса пароля не может быть пустым.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Токен для сброса пароля уже был использован.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['passwordConfirm', 'required'],
            ['password', 'string', 'min' => 8],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword($send = true)
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        \Yii::$app->session->set('pass', $this->password);
        if ($send)
            $this->sendEmail($user);

        return $user->save(false);
    }

    public function sendEmail($user)
    {
        if (!$user) {
            return false;
        }

        return \Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordReset-html'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => ' ' . \Yii::$app->name])
            ->setTo($user->email)
            ->setSubject('Восстановление аккаунта - Новый пароль - ' . \Yii::$app->name)
            ->send();
    }

    public function getUser()
    {
        return $this->_user ? $this->_user : false;
    }
}
