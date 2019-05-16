<?php
namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

class RestorePasswordForm extends Model
{
    public $email;
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
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Пользователь не найден с этим адресом электронной почты.'
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
         ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
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
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => ' ' . \Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Восстановление аккаунта - ' . \Yii::$app->name)
            ->send();
    }
}
