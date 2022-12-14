<?php

namespace app\modules\user\models;

use yii\base\Model;

class ResetNewPasswordForm extends Model
{

    public $password;
    public $passwordRepeat;

    public function rules(): array
    {
        return User::rulesPassword();
    }

    public function attributeLabels(): array
    {
        return [
            'password' => 'Новый пароль',
            'passwordRepeat' => 'Повторите пароль'
        ];
    }

    public function setNewPassword($token): bool
    {
        if ($this->validate()) {

            $user = User::findByPasswordToken($token);
            $user->password = $user->setPassword($this->password);
            $user->password_reset_token = NULL;

            if ($user->save()) return true;

        }

        return false;
    }

}