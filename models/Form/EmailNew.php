<?php

namespace app\models\Form;

use app\models\User;
use app\service\EmailChangeDispatcher;
use cs\Application;
use cs\services\dispatcher\EmailChange;
use cs\web\Exception;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 *
 */
class EmailNew extends Model
{
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'email',
                    'password'
                ],
                'required',
                'message' => 'Это поле должно быть заполнено обязательно'
            ],
            [
                [
                    'email',
                ],
                'email',
            ],
            [
                [
                    'email',
                ],
                'emailValidate',
            ],
            [
                [
                    'password',
                ],
                'passwordValidate',
            ],
        ];
    }

    public function passwordValidate($attribute, $params)
    {
        /** @var \app\models\User $user */
        $user = Yii::$app->user->identity;
        if (!$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Пароль не верный');
        }
    }

    public function emailValidate($attribute, $params)
    {
        if (User::query(['email' => $this->email])->exists()) {
            $this->addError($attribute, 'Такой пользоатель уже есть');
        }
    }

    /**
     * @return boolean
     *
     * @throws \cs\web\Exception
     */
    public function action()
    {
        if ($this->validate()) {
            /** @var \app\models\User $user */
            $user = Yii::$app->user->identity;
            // добавляю в диспечер
            $fields = \app\services\EmailChangeDispatcher::add($user->getId(), $this->email);
            // отправляю письмо
            Application::mail($this->email, 'Заявка на смену Email/Логина', 'change_email', [
                'url'  => Url::to(['auth/change_email_activate', 'code' => $fields->getField('code')], true),
                'user' => $user
            ]);

            return true;
        }
        else {
            return false;
        }
    }
}
