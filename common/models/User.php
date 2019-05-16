<?php
namespace common\models;

use common\models\enum\Role;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $role
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $comment
 * @property integer $status
 * @property float $withdraw_percent
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Referrals $referral
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

    const SCENARIO_ADD = 'add';

    const MIN_PERCENT = '0';

    const MAX_PERCENT = '100';


    public $password;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'default', 'value' => Role::END_USER],

            [['username', 'role'], 'required'],
            [['username', 'email'], 'required','on' => [self::SCENARIO_ADD]],

            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => Role::getList()],

            [['username', 'email'], 'unique'],
            [['password_reset_token'], 'unique'],


            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['withdraw_percent', 'default', 'value' => 0],
            [['withdraw_percent'], 'number','min' => self::MIN_PERCENT, 'max' => self::MAX_PERCENT, 'numberPattern'=>'/^\d{1,4}([.]\d{0,4})?$/','message'=>'Количество знаков после запятой не должно быть больше четырех.'],

            [['comment','withdraw_percent'], 'safe'],
        ];
    }

    public function beforeValidate(){
        if ($this->scenario === self::SCENARIO_ADD) {
            $this->role = Role::END_USER;
            $this->password = Yii::$app->getSecurity()->generateRandomString();
            $this->generatePasswordResetToken();
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        }

        if ($this->password) {
            $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $attr)
    {
        if ($insert) {
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->role), $this->id);

            (new Referrals([
                'user_id' => $this->id,
                'rate' => Referrals::DEFAULT_RATE,
                'referrer' => $this->generateRefLink()
            ]))->save();
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return $this->email;
    }


    public static function updateRole($key, $newRole)
    {
        $user = User::find()->where([ "id" => (int) $key ])->one();
        if (!$user || !in_array($newRole, Role::getList())) {
            return false;
        }
        $auth = Yii::$app->authManager;
        $oldRole = $user->role;
        $auth->revoke(Yii::$app->authManager->getRole($oldRole), $user->id);
        $auth->assign(Yii::$app->authManager->getRole($newRole), $user->id);
        $user->role = $newRole;
        return $user->save(false);
    }

    public static function updateComment($key, $comment)
    {
        $user = User::find()->where([ "id" => (int) $key ])->one();
        $user->comment = $comment;
        return $user->save(false);
    }

    public function getReferral()
    {
        return $this->hasOne(Referrals::className(), ['user_id' => 'id']);
    }

    public function generateRefLink()
    {
        return 'ref' . $this->id;
    }
}
