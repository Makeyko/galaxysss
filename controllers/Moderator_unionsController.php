<?php

namespace app\controllers;

use app\models\Article;
use app\models\SiteUpdate;
use app\models\Union;
use app\services\Subscribe;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Moderator_unionsController extends AdminBaseController
{

    private function doAction($id, $callback)
    {
        $item = \app\models\Union::find($id);
        if (is_null($item)) {
            return self::jsonErrorId(101, 'Не найдено объединение');
        }
        $callback($item);

        return self::jsonSuccess();
    }

    public function actionIndex()
    {
        return $this->render([
            'items' => Union::query(['moderation_status' => null])->all(),
        ]);
    }

    public function actionAccept($id)
    {
        return self::doAction($id, function (\app\models\Union $item) {
            $item->accept();
            \cs\Application::mail($item->getUser()->getEmail(), 'Ваше объединение прошло модерацию', 'moderator_unions/accept', [
                    'item' => $item
                ]);

            // делаю рассылку что добавлено такое объединение
            {
                Subscribe::add($item);
                SiteUpdate::add($item);
                $item->update(['is_added_site_update' => 1]);
            }
        });
    }

    public function actionReject($id)
    {
        return self::doAction($id, function (\app\models\Union $item) {
            $item->reject();
            \cs\Application::mail($item->getUser()->getEmail(), 'Ваше объединение отклонено модератором', 'moderator_unions/reject', [
                    'item'   => $item,
                    'reason' => self::getParam('reason'),
                ]);
        });
    }

    public function actionDelete($id)
    {
        return self::doAction($id, function (\app\models\Union $item) {
            $item->delete();
        });
    }
}
