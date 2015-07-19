<?php

namespace app\controllers;

use app\models\User;
use app\services\RegistrationDispatcher;
use cs\base\BaseController;
use Yii;
use cs\web\Exception;
use app\services\Subscribe;
use yii\helpers\Url;

class SubscribeController extends BaseController
{
    public $layout = 'menu';

    /**
     * Выполняет отписку от рассылки
     *
     * REQUEST:
     * - mail - string - почта пользователя
     * - type - int - тип рассылки - \app\services\Subscribe::TYPE_*
     * - hash - string - проверочная сумма (чтобы нельзя было отписать другого)
     *
     * @return string
     *
     * @throws \cs\web\Exception
     */
    public function actionUnsubscribe()
    {
        self::validateRequestJson([
            ['required', ['mail', 'type', 'hash']],
            ['integer', ['type']],
            ['email', ['mail']],
        ]);
        $mail = self::getParam('mail');
        $type = self::getParam('type');
        $hash = self::getParam('hash');

        $user = User::find(['email' => $mail]);
        if (is_null($user)) {
            throw new Exception('Пользователь не найден');
        }
        $user = User::find([
            'email'      => $mail,
            'is_confirm' => 1,
        ]);
        if (is_null($user)) {
            throw new Exception('Пользователь не подтвержден');
        }
        $user = User::find([
            'email'      => $mail,
            'is_confirm' => 1,
            'is_active'  => 1,
        ]);
        if (is_null($user)) {
            throw new Exception('Пользователь заблокирован');
        }
        if (!Subscribe::hashValidate($mail, $type, $hash)) {
            throw new Exception('Контрольная сумма не совпадает, проверьте привильность введенной ссылки');
        }
        switch ($type) {
            case Subscribe::TYPE_NEWS:
                $user->update(['subscribe_is_news' => 0]);
                break;
            case Subscribe::TYPE_SITE_UPDATE:
                $user->update(['subscribe_is_site_update' => 0]);
                break;
            default:
                throw new Exception('Не верный тип рассылки');
                break;
        }

        return self::render();
    }

    /**
     * AJAX
     * Создает подписку для авторизованного или неавторизованного пользователя
     * Высылает письмо подтверждения email
     *
     */
    public function actionMail()
    {
        $email =  self::getParam('email');
        $name =  self::getParam('name');

        if (Yii::$app->user->isGuest) {
            $user = User::insert([
                'email'                    => $email,
                'subscribe_is_site_update' => 1,
                'subscribe_is_news'        => 1,
                'datetime_reg'             => gmdate('YmdHis'),
                'is_active'                => 0,
                'is_confirm'               => 0,
                'name_first'               => $name,
            ]);
        } else {
            /** @var \app\models\User $user */
            $user = Yii::$app->user->identity;
            $user->update([
                'email'                    => $email,
                'subscribe_is_site_update' => 1,
                'subscribe_is_news'        => 1,
                'datetime_reg'             => gmdate('YmdHis'),
                'is_active'                => 0,
                'is_confirm'               => 0,
            ]);
        }
        $fields = RegistrationDispatcher::add($user->getId());
        \cs\Application::mail($email, 'Подтверждение почты', 'subscribe_activate', [
            'url'      => Url::to([
                'subscribe/activate',
                'code' => $fields['code']
            ], true),
            'user'     => $user,
            'datetime' => \Yii::$app->formatter->asDatetime($fields['date_finish'])
        ]);

        return self::jsonSuccess();
    }

    /**
     * Активация подписки
     *
     * @param string $code
     *
     * @return string
     * @throws Exception
     */
    public function actionActivate($code)
    {
        $row = RegistrationDispatcher::query(['code' => $code])->one();
        if ($row === false) {
            throw new Exception('Срок ссылки истек или не верный код активации');
        }
        $user = User::find($row['parent_id']);
        if (is_null($user)) {
            throw new Exception('Пользователь не найден');
        }
        $user->update([
            'is_active'  => 1,
            'is_confirm' => 1,
        ]);
        RegistrationDispatcher::delete($row['parent_id']);

        return $this->render();
    }
}
