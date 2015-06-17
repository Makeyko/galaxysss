<?php

namespace app\models\Form;

use app\models\User;
use cs\web\Exception;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 *
 */
class PasswordNew extends Model
{
    public $password1;
    public $password2;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'password1',
                    'password2'
                ],
                'required',
                'message' => 'Это поле должно быть заполнено обязательно'
            ],
            [
                [
                    'password1',
                    'password2'
                ],
                'passwordValidate',
            ],
        ];
    }

    public function passwordValidate($attribute, $params)
    {
        if ($this->password1 != '' and $this->password2 != '') {
            if ($this->password1 != $this->password2) {
                $this->addError($attribute, 'Пароли должны совпадать');
            }
        }
    }

    /**
     * Устанавливает
     *
     * @param  \app\models\User $user
     *
     * @return boolean
     *
     * @throws \cs\web\Exception
     */
    public function action(\app\models\User $user)
    {
        if ($this->validate()) {
            return $user->setPassword($this->password1);
        }
        else {
            return false;
        }
    }
}
