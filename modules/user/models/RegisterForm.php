<?php


namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $phone;
    public $email;
    public $password;
    public $passwordRepeat;

    private $_user = false;

    public function rules()
    {
        $array = [
            [['username', 'email'], 'required', 'message' => 'Заполните поле'],

            ['username', 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => '{attribute} должен содержать только латиские буквы и цифры'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Такой "{attribute}" уже зарегестрирован'],
            ['username', 'string', 'length' => [5, 30], 'tooShort' => '{attribute} должен состоять от {min} символов', 'tooLong' => '{attribute} должен состоять до {max} символов включительно'],

            ['email', 'trim'],
            ['email', 'email', 'message' => 'Не верно введен "{attribute}"'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Такой "{attribute}" уже зарегестрирован'],

            ['phone', 'string'],
            ['phone', 'unique', 'targetClass' => User::class, 'message' => 'Такой "{attribute}" уже зарегестрирован'],
        ];

        return array_merge(User::rulesPassword(), $array);
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'phone' => 'Телефон',
            'email' => 'Email',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль'
        ];
    }

    public function tryRegister()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->phone = $this->phone;
            $user->email = $this->email;
            $user->password = $user->setPassword($this->password);
            if ($user->save()) {
                return $user;
            }
        }

        return false;
    }

}