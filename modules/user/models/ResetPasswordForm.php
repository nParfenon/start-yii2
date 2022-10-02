<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{

    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Заполните поле'],
            ['email', 'trim'],
            ['email', 'email', 'message' => 'Не верно введен "{attribute}"'],
            ['email', 'exist', 'targetClass' => User::class, 'message' => 'Такой "{attribute}" не зарегистрирован']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    public function tryToken()
    {
        if ($this->validate()) {

            $user = User::findByEmail($this->email);
            $token = Yii::$app->security->generateRandomString().$user->id;
            $user->password_reset_token = $token;
            if ($user->save()) return $token;

        }

        return false;
    }

}