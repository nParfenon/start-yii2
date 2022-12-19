<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use app\models\CustomForm;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        $array = [
            [['username','password'], 'required','message' => 'Заполните поле {attribute}'],

            ['username', 'match', 'pattern' => '/^[A-Za-z0-9]+$/','message' => 'Логин должен содержать только латиские буквы и цифры'],

            ['rememberMe', 'boolean'],

            ['password', 'validatePassword'],

            ['username', 'validateStatus'],

        ];

        return array_merge(parent::rules(), $array);
    }

    public function attributeLabels(): array
    {
        $array = [
            'username' => 'Логин',
            'password'=>'Пароль',
            'rememberMe' => 'Запомнить',
            'message'=>'Сообщение',
        ];

        return array_merge(parent::attributeLabels(), $array);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array|null $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, array|null $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) $this->addError($attribute, 'Логин или пароль введены не верно');

        }
    }

    public function validateStatus(string $attribute, array|null $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validateStatus()) $this->addError($attribute, 'Пользователь был удален или заблокирован');

        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function tryLogin(): bool
    {
        if (!$this->validate()) return false;

        if ($this->rememberMe) {

            $authKey = $this->getUser();
            $authKey->generateAuthKey();
            $authKey->save();

        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser(): User|null
    {
        if ($this->_user === false) $this->_user = User::findByUsername($this->username);

        return $this->_user;
    }
}