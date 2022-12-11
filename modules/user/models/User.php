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
 * @property string $password
 * @property string|null $password_reset_token
 * @property int $status
 * @property int|null $isAdmin
 * @property string|null $authKey
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends CustomModel implements \yii\web\IdentityInterface
{

    const _ACTIVE = 1;
    const _BANNED = 2;
    const _DELETED = 3;

    const _STATUS = [
        self::_ACTIVE => 'Активен',
        self::_BANNED => 'Заблокирован',
        self::_DELETED => 'Удален'
    ];

    const _SUPER_ADMIN_ID = 1;
    const _SUPER_ADMIN = 'admin';

    private const _TOKEN_LENGHT = 32; /* Длина первой части токена */
    private const _PREFIX = '_it'; /* Разделитель для токена*/
    private const _TIME = 60 * 30; /* Время действия токена*/

    public $newPassword;

    /**
     * {@inheritdoc}
     */
    public function ignoreAttributeLog(): array
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
            ['username', 'string' ,'max' => 25],
            ['email', 'string' ,'max' => 255],

            ['username', 'unique', 'targetClass' => self::class, 'message' => 'Такой "{attribute}" уже зарегестрирован'],

            ['email', 'trim'],
            ['email', 'email', 'message' => 'Не верно введен "{attribute}"'],
            ['email', 'unique', 'targetClass' => self::class, 'targetAttribute' => 'email', 'message' => 'Такой "{attribute}" уже зарегестрирован'],

            ['status', 'integer'],

            [['isAdmin'],'boolean'],
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
            ['password', 'string', 'length' => [6, 25], 'tooShort' => '{attribute} должен состоять от {min} символов', 'tooLong' => '{attribute} должен состоять до {max} символов включительно'],
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
            'email' => 'Email',
            'role' => 'Роль',
            'password' => 'Пароль',
            'password_reset_token' => 'Токен сброса пароля',
            'status' => 'Статус',
            'isAdmin' => 'Админ',
            'authKey' => 'Ключ аутентификации',
            'newPassword' => 'Новый пароль'
        ] ;

        return array_merge(parent::attributeLabels(), $array);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->id === self::_SUPER_ADMIN_ID || $this->username === self::_SUPER_ADMIN) {

            if ($this->username !== self::_SUPER_ADMIN) return false;

            if ($this->isAdmin == false) return false;

            if ($this->status != self::_ACTIVE) return false;

        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if ($this->id === self::_SUPER_ADMIN_ID || $this->username === self::_SUPER_ADMIN) return false;

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

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Проверка на активного пользователя
     */
    public function validateStatus()
    {
        return $this->status === self::_ACTIVE;
    }

    /**
     * Генерирует авторизационный ключ
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
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
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    /**
     * Генерирует пароль
     */
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерирует токен для сброса пароля
     */
    public static function generatePasswordToken(int $id): string
    {
        return Yii::$app->security->generateRandomString(self::_TOKEN_LENGHT) . $id . self::_PREFIX  . time() + self::_TIME;
    }

    /**
     * Осуществляет поиск по токену
     */
    public static function findByPasswordToken(string $token)
    {
        $exp = explode(self::_PREFIX, substr($token, self::_TOKEN_LENGHT));

        if (count($exp) != 2) return false;

        $time = array_pop($exp);
        $id = array_pop($exp);

        if ( !is_numeric($time) || !is_numeric($id) || !$user = User::find()->where(['id' => $id])->andWhere(['= BINARY', 'password_reset_token', $token])->one() ) return false;

        if ($time < time()) {

            $user->password_reset_token = NULL;
            $user->save();

            return false;

        }

        return $user;
    }
}
