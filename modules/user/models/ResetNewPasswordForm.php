<?php


namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class ResetNewPasswordForm extends Model
{

    public $password;
    public $passwordRepeat;

    public function rules()
    {
        return User::rulesPassword();
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'passwordRepeat' => 'Повторите пароль'
        ];
    }

    public function tryNewPassword($token)
    {
        if ($this->validate()) {

            $user = User::findByPasswordResetToken($token);
            $user->password = $user->setPassword($this->password);
            $user->password_reset_token = null;
            if ($user->save()) return true;

        }

        return false;
    }

}