<?php

namespace frontend\models\forms;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $newPasswordConfirm;

    /**
     * @var User
     */
    private $_user = null;

    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'newPasswordConfirm' => 'Повторите пароль',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'newPasswordConfirm'], 'required'],
            [['newPassword', 'newPasswordConfirm'], 'string', 'min' => 8],
            [['newPassword'], 'newPasswordValidator'],
            ['newPasswordConfirm', 'compare', 'compareAttribute' => 'newPassword']
        ];
    }

    public function newPasswordValidator()
    {
        if (!$this->getUser()->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', 'Не верный старый пароль');
        }
    }

    public function changePassword()
    {
        $this->getUser()->setPassword($this->newPassword);
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \Yii::$app->user->getIdentity();
        }

        return $this->_user;
    }
}
