<?php

namespace app\models\Form;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Registration extends \cs\base\BaseForm
{
    public $email;
    public $password1;
    public $password2;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'password1', 'password2'], 'required', 'message' => 'Это поле должно быть заполнено обязательно'],
            // email has to be a valid email address
            ['email', 'email', 'message' => 'Email должен быть верным'],
            ['email', 'validateEmail'],
            ['password1', 'validatePassword'],
            ['password2', 'validatePassword'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'message' => 'Неверный код'],
        ];
    }

    public function scenarios()
    {
        return [
            'insert' => ['email', 'password1', 'password2', 'verifyCode'],
            'ajax'   => ['email', 'password1', 'password2'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Проверочный код',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password1 != '' && $this->password2 != '') {
            if ($this->password1 != $this->password2) {
                $this->addError($attribute, 'Пароли должны совпадать');
            }
        }
    }

    public function validateEmail($attribute, $params)
    {
        if (User::query(['email' => $this->email])->exists()) {
            $this->addError($attribute, 'Такой пользователь уже есть');
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     *
     * @return boolean whether the model passes validation
     */
    public function register()
    {
        if ($this->validate()) {
            \app\models\User::registration($this->email, $this->password1);

            return true;
        } else {
            return false;
        }
    }
}
