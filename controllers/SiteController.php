<?php

namespace app\controllers;

use app\models\Form\Event;
use app\models\User;
use app\services\GetArticle\YouTube;
use cs\base\BaseController;
use cs\services\SitePath;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\services\RegistrationDispatcher;

class SiteController extends BaseController
{
    public $layout = 'menu';

    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
                'view'  => '@app/views/site/error.php'
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $path = Yii::getAlias('@app/app/assets/1.xml');
        $data = file_get_contents($path);
        require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
        $x = new \DOMDocument();
        $x->loadXML($data);

        $ret = [];
        /** @var \DOMElement $element */
        foreach ($x->documentElement->childNodes as $element) {
            if ($element instanceof \DOMElement) {
                $data = $element->getAttribute('data-jmapping');
                $pos = Str::pos('lat', $data);
                $pos1 = Str::pos('lng', $data);
                $lat = Str::sub($data, $pos + 5, $pos1 - $pos - 7);
                $pos = Str::pos('lng', $data);
                $pos1 = Str::pos('category', $data);
                $lng = Str::sub($data, $pos + 5, $pos1 - $pos - 8);
                $pos = Str::pos('category', $data);
                $category = Str::sub($data, $pos + 11);
                $category = Str::sub($category, 0, Str::length($category) - 2);
                $category = explode('|', $category);
                $list = $element->getElementsByTagName("p");
                if ($list->length == 1) {
                    /** @var \DOMElement $content */
                    $content = $list[0];
                    $content = $x->saveXML($content);

                    $content = Str::sub($content,3);
                    $content = Str::sub($content,0, Str::length($content) - 4);
                    $content = explode('<br/>', $content);
                    $ret2 = [];
                    foreach ($content as $item) {
                        if ( StringHelper::startsWith($item,'<b>')) {
                            $item = Str::sub($item,3);
                            $item = Str::sub($item, 0, Str::length($item) - 4);
                        }
                        $ret2[] = trim($item, "\r");
                    }

                    $ret[] = [
                        'lat'     => $lat,
                        'lng'     => $lng,
                        'category'=> $category,
                        'content' => $ret2,
                    ];
                }
            }
        }
        //VarDumper::dump($ret);

        return $this->render('index', [
            'events' => \app\models\Event::query()->limit(3)->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionLog()
    {
        return $this->render([
            'log' => file_get_contents(Yii::getAlias('@runtime/logs/app.log')),
        ]);
    }
}
