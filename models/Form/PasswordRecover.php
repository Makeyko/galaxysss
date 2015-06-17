<?php

namespace app\models\Form;

use app\models\User;
use cs\web\Exception;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * ContactForm is the model behind the contact form.
 */
class PasswordRecover extends \cs\base\BaseForm
{
    public $email;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                'email',
                'required',
                'message' => 'Это поле должно быть заполнено обязательно'
            ],
            [
                'email',
                'email',
                'message' => 'Email должен быть верным'
            ],
            [
                'email',
                'validateEmail'
            ],
            [
                'verifyCode',
                'captcha',
                'message' => 'Неверный код'
            ],
        ];
    }

    public function scenarios()
    {
        return [
            'insert' => [
                'email',
                'verifyCode'
            ],
            'ajax'   => ['email'],
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

    public function validateEmail($attribute, $params)
    {
        if (!User::query(['email' => $this->email])->exists()) {
            $this->addError($attribute, 'Такой пользователь не найден');
        }
        if (!User::query([
            'email'      => $this->email,
            'is_confirm' => 1,
        ])->exists()
        ) {
            $this->addError($attribute, 'Пользователь еще не подтвердил свой email');
        }
        if (!User::query([
            'email'     => $this->email,
            'is_active' => 1,
        ])->exists()
        ) {
            $this->addError($attribute, 'Пользователь заблокирован');
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     *
     * @return boolean whether the model passes validation
     *
     * @throws \cs\web\Exception
     */
    public function send()
    {
        if ($this->validate()) {
            $user = User::find(['email' => $this->email]);
            if (is_null($user)) {
                throw new Exception('Пользователь не найден');
            }
            $fields = \app\services\PasswordRecoverDispatcher::insert($user->getId());
            \cs\Application::mail($this->email, 'Восстановление пароля', 'password_recover', [
                'user'     => $user,
                'url'      => Url::to([
                    'auth/password_recover_activate',
                    'code' => $fields['code']
                ], true),
                'datetime' => Yii::$app->formatter->asDatetime($fields['date_finish']),
            ]);

            return true;
        }
        else {
            return false;
        }
    }
}
