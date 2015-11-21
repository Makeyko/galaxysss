<?php

namespace app\models;

use cs\base\BaseForm;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends BaseForm
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    public function __construct($config = [])
    {
        self::$fields = [
            [
                'username', 'Логин',1,'string'
            ],
            [
                'password', 'Пароль',1,'string'
            ],
            [
                'rememberMe', 'Запомнить меня', 0, 'cs\Widget\CheckBox2\Validator',
                'widget' => ['cs\Widget\CheckBox2\CheckBox', []]
            ],
        ];
        parent::__construct($config);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return ArrayHelper::merge([
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['username', 'validateUser'],
        ], $this->rulesAdd());
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUser($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (is_null($user)) {
                $this->addError($attribute, 'Пользователя нет');
                return;
            }
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (is_null($user)) {
                return;
            }

            if ($user->validatePassword($this->password) == false) {
                $this->addError($attribute, 'Не верный пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
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
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
