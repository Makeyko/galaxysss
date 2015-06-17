<?php

namespace app\controllers;

use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use app\models\Chenneling;
use cs\base\BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdminBaseController extends BaseController
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
                        'matchCallback' => function() {
                            /** @var \app\models\User $user */
                            $user = \Yii::$app->user->identity;
                            return ($user->getField('is_admin') == 1);
                        }
                    ],
                ],
            ],
        ];
    }
}
