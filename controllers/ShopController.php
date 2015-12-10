<?php

namespace app\controllers;

use app\models\Article;
use app\models\Blog;
use app\models\Form\Shop\Order;
use app\models\Praktice;
use app\models\Service;
use app\models\Shop\Product;
use app\models\Union;
use app\models\UnionCategory;
use app\modules\Shop\services\Basket;
use app\services\HumanDesign2;
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


class ShopController extends BaseController
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

    public function actionIndex()
    {
        return $this->render([

        ]);
    }

    /**
     * AJAX
     * Добавление товара в корзину
     * REQUEST
     * - id - int - идентификатор товара gs_unions_shop_product.id
     *
     * @return string
     */
    public function actionBasket_add()
    {
        $id = self::getParam('id');
        $product = Product::find($id);
        if (is_null($product)) {
            return self::jsonErrorId(101, 'Не найден товар');
        }
        $count = Basket::add($product);

        return self::jsonSuccess($count);
    }


    public function actionBasket()
    {
        return $this->render([
            'items' => Basket::get()
        ]);
    }

    public function actionOrder()
    {
        $model = new Order();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

}
