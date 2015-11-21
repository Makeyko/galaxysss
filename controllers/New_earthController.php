<?php

namespace app\controllers;

use app\models\Article;
use app\models\Praktice;
use app\models\Service;
use app\models\Union;
use app\models\UnionCategory;
use cs\Application;
use cs\services\Str;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\grid\DataColumn;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use app\models\Chenneling;
use cs\base\BaseController;
use yii\web\HttpException;


class New_earthController extends BaseController
{
    public $layout = 'menu';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionCivilizations_item($name)
    {
        return $this->render('civilizations/'.$name, []);
    }

    public function actionIndex()
    {
        return $this->render();
    }

    public function actionChakri()
    {
        return $this->render();
    }

    public function actionKon()
    {
        return $this->render();
    }

    public function actionHymn()
    {
        return $this->render();
    }

    public function actionManifest()
    {
        return $this->render();
    }

    public function actionCodex()
    {
        return $this->render();
    }

    public function actionPrice()
    {
        return $this->render();
    }

    public function actionDeclaration()
    {
        return $this->render();
    }

    public function actionResidence()
    {
        return $this->render();
    }

    public function actionPledge()
    {
        return $this->render();
    }

    public function actionProgram()
    {
        return $this->render();
    }

    public function actionHistory()
    {
        return $this->render();
    }
}
