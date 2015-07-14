<?php

namespace app\controllers;

use app\models\User;
use cs\base\BaseController;
use Yii;
use cs\web\Exception;
use app\services\Subscribe;

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
            [['mail', 'type', 'hash',], 'required'],
            [['type'], 'integer'],
            [['mail',], 'email'],
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
}
