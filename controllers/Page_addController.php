<?php

namespace app\controllers;

use cs\services\VarDumper;
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

class PageController extends BaseController
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

    public function actionHouse()
    {
        return $this->render('house');
    }

    public function actionMedical()
    {
        return $this->render('medical');
    }

    public function actionMission()
    {
        return $this->render('mission');
    }

    public function actionUp()
    {
        return $this->render('up');
    }

    public function actionStudy()
    {
        $model = new \app\models\Form\Union(1);
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionTime()
    {
        return $this->render('time');
    }

    public function actionLanguage()
    {
        return $this->render('language');
    }

    public function actionEnergy()
    {
        return $this->render('energy');
    }

    public function actionMoney()
    {
        return $this->render('money');
    }

    public function actionFood()
    {
        return $this->render('food');
    }

    public function actionForgive()
    {
        return $this->render('forgive');
    }

    public function actionTv()
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

    public function actionClothes()
    {
        return $this->render();
    }
}
