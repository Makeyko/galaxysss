<?php

namespace app\modules\Comment;

use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use app\models\Chenneling;
use cs\base\BaseController;
use app\services\UsersInCache;

class Controller extends BaseController
{
    public $layout = 'menu';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * AJAX
     * Оставляет комментарий в статье
     *
     * @return string
     * {
     *      text: str,
     *      user: {
     *              id: int,
     *              name: str,
     *              avatar: str,
     *            }
     * }
     */
    public function actionSend()
    {
        $type_id = self::getParam('type_id');
        $row_id = self::getParam('row_id');
        $content = self::getParam('Form')['content'];
        Model::insert([
            'type_id' => $type_id,
            'row_id'  => $row_id,
            'content' => $content,
            'user_id' => Yii::$app->user->getId(),
        ]);
        (new \app\modules\Comment\Cache([
            'typeId' => $type_id,
            'rowId'  => $row_id,
        ]))->clear();

        return self::jsonSuccess([
            'text' => $content,
            'user' => (new UsersInCache)->getUserData(Yii::$app->user->identity),
        ]);
    }
}
