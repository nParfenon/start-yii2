<?php

namespace app\modules\user\models;

use Yii;
use app\models\CustomModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $phone
 * @property string $password
 * @property string|null $password_reset_token
 * @property string|null $authKey
 * @property int|null $isAdmin
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends CustomModel implements \yii\web\IdentityInterface
{

    const SUPER_ADMIN_ID = 1;
    const SUPER_ADMIN = 'admin';

    public $newPassword;

    /**
     * {@inheritdoc}
     */
    public function ignoreAttributeLog() : array
    {
        $array = [
            'password_reset_token',
            'authKey'
        ];

        return array_merge(parent::ignoreAttributeLog(), $array);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Данные правила участвуют только при добавлении через админку
     * {@inheritdoc}
     */
    public function rules()
    {
        $array = [
            [['username', 'email', 'password'], 'required', 'message' => 'Заполните поле'],
            ['newPassword', 'string'],
            ['username', 'string' ,'max' => 30],
            ['email', 'string' ,'max' => 255],
            ['phone', 'string' ,'max' => 40],

            ['username', 'unique', 'targetClass' => self::class, 'message' => 'Такой "{attribute}" уже зарегестрирован'],

            ['email', 'trim'],
            ['email', 'email', 'message' => 'Не верно введен "{attribute}"'],
            ['email', 'unique', 'targetClass' => self::class, 'targetAttribute' => 'email', 'message' => 'Такой "{attribute}" уже зарегестрирован'],

            [['isAdmin'],'boolean'],

            ['phone', 'unique', 'targetClass' => self::class, 'message' => 'Такой "{attribute}" уже зарегестрирован'],
        ];

        return array_merge(parent::rules(), $array);
    }

    /**
     * Правила для регистрации пользователей и при смены пароля в случае, если человек его забыл
     */
    public static function rulesPassword()
    {
        return [
            [['password', 'passwordRepeat'], 'required', 'message' => 'Заполните поле'],
            ['password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z])([a-zA-Z0-9]+)$/', 'message' => '{attribute} должен содержать латинские заглавные и строчные буквы, цифры'],
            ['password', 'string', 'length' => [6, 100], 'tooShort' => '{attribute} должен состоять от {min} символов', 'tooLong' => '{attribute} должен состоять до {max} символов включительно'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $array = [
            'id' => 'ID',
            'username' => 'Логин',
            'phone' => 'Телефон',
            'email' => 'Email',
            'role' => 'Роль',
            'password' => 'Пароль',
            'password_reset_token' => 'Токен сброса пароля',
            'authKey' => 'Ключ аутентификации',
            'isAdmin' => 'Админ',
            'newPassword' => 'Новый пароль'
        ] ;

        return array_merge(parent::attributeLabels(), $array);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->id === self::SUPER_ADMIN_ID || $this->username === self::SUPER_ADMIN){
            if ($this->username !== self::SUPER_ADMIN || $this->isAdmin == false){
                return false;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if ($this->id === self::SUPER_ADMIN_ID || $this->username === self::SUPER_ADMIN){
            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function findByPasswordResetToken($token)
    {
        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return  Yii::$app->security->validatePassword($password,$this->password);
    }

    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }
}
