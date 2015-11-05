<?php

namespace app\controllers;

use app\models\Form\Union;
use app\models\HD;
use app\models\HDtown;
use app\models\SiteUpdate;
use app\models\User;
use app\services\Subscribe;
use cs\Application;
use cs\services\SitePath;
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
use cs\base\BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CabinetBaseController extends BaseController
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

}
