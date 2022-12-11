<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{

    public $email;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Заполните поле'],
            ['email', 'trim'],
            ['email', 'email', 'message' => 'Не верно введен "{attribute}"'],
            ['email', 'exist', 'targetClass' => User::class, 'message' => 'Такой "{attribute}" не зарегистрирован'],

            ['email', 'validateStatus']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    public function validateStatus($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validateStatus()) $this->addError($attribute, 'Пользователь был удален или заблокирован');

        }
    }

    public function setPasswordToken()
    {
        if ($this->validate()) {

            $user = User::findByEmail($this->email);

            $token = User::generatePasswordToken($user->id);

            $user->password_reset_token = $token;

            if ($user->save()) return $token;

        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) $this->_user = User::findByEmail($this->email);

        return $this->_user;
    }

}