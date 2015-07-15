<?php

namespace app\controllers;

use app\models\Article;
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
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use app\models\Chenneling;
use cs\base\BaseController;


class PageController extends BaseController
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

    public function actionHouse()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(3),
        ]);
    }

    public function actionMedical()
    {
        return $this->render('medical');
    }

    public function actionTest()
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

    public function actionServices()
    {
        return $this->render([
            'list' => Service::query()->all(),
        ]);
    }

    public function actionServices_item($id)
    {
        return $this->render([
            'item' => Service::find($id)
        ]);
    }

    public function actionMission()
    {
        return $this->render();
    }

    public function actionCodex()
    {
        return $this->render();
    }

    public function actionColkin()
    {
        return $this->render();
    }

    public function actionArts()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(12),
        ]);
    }

    public function actionUp()
    {
        return $this->render();
    }

    public function actionStudy()
    {
        return $this->render();
    }

    public function actionGfs()
    {
        return $this->render();
    }

    public function actionTime()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(2),
        ]);
    }

    /**
     * Выводит подкатегорию
     *
     * @param $id
     *
     * @return string
     * @throws Exception
     */
    public function actionCategory($id)
    {
        $category = UnionCategory::find(['id_string' => $id]);
        if (is_null($category)) {
            throw new Exception('Нет такой категории');
        }

        return $this->render([
            'item'        => $category,
            'unionList'   => $category->getUnions(),
            'articleList' => Article::getByTreeNodeId($category->getId()),
            'breadcrumbs' => [
                'label' => $category->getField('header'),
                'url'   => '/' . $id,
            ],
            'idString' => $id
        ]);
    }

    public function actionLanguage()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(1),
        ]);
    }

    public function actionEnergy()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(7),
        ]);
    }

    public function actionMoney()
    {
        return $this->render();
    }

    public function actionFood()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(4),
        ]);
    }

    public function actionFood_item($id)
    {
        $item = Union::find($id);

        return $this->render([
            'item'       => $item,
            'officeList' => $item->getOfficeList([
                'point_lat as lat',
                'point_lng as lng',
                'concat("<h5>",name,"</h5><p>",point_address,"</p>") as html',
            ])
        ]);
    }

    public function actionUnion_item($category, $id)
    {
        $item = Union::find($id);
        if (is_null($item)) {
            throw new Exception('Нет такого объединения');
        }
        $categoryObject = UnionCategory::find(['id_string' => $category]);
        if (is_null($categoryObject)) {
            throw new Exception('Не найдена категория');
        }

        return $this->render([
            'item'        => $item,
            'officeList'  => $item->getOfficeList([
                'id',
                'point_lat as lat',
                'point_lng as lng',
                'concat("<h5>",name,"</h5><div>",ifnull(content,""),"</div><p>",point_address,"</p>") as html',
            ]),
            'breadcrumbs' => [
                'label' => $categoryObject->getField('header'),
                'url'   => '/' . $category,
            ],
        ]);
    }

    public function actionForgive()
    {
        return $this->render([
            'articleList' => Article::getByTreeNodeId(8),
        ]);
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

    public function actionPortals()
    {
        return $this->render();
    }

    public function actionMusic()
    {
        return $this->render();
    }

    public function actionIdea()
    {
        return $this->render();
    }

    public function actionNews()
    {
        return $this->render([
            'items' => NewsItem::query()->orderBy(['date_insert' => SORT_DESC])->all()
        ]);
    }

    public function actionNews_item($year, $month, $day, $id)
    {
        $date = $year . $month . $day;
        $newsItem = NewsItem::find([
            'date'      => $date,
            'id_string' => $id
        ]);
        if (is_null($newsItem)) {
            throw new Exception('Нет такой новости');
        }
        $newsItem->incViewCounter();

        $row = $newsItem->getFields();

        return $this->render([
            'newsItem' => $newsItem->getFields(),
            'lastList' => NewsItem::query()->where([
                'not in',
                'id',
                $row['id']
            ])->orderBy(['date_insert' => SORT_DESC])->limit(3)->all(),
        ]);
    }

    public function actionLanguage_article($id)
    {
        $item = Article::find([
            'id_string' => $id
        ]);
        if (is_null($item)) {
            throw new Exception('Нет такой статьи');
        }
        $item->incViewCounter();

        return $this->render([
            'item' => $item->getFields()
        ]);
    }

    public function actionArticle($category, $year, $month, $day, $id)
    {
        $item = Article::find([
            'id_string'   => $id,
            'DATE(date_insert)' => $year . $month . $day
        ]);
        if (is_null($item)) {
            throw new Exception('Нет такой статьи');
        }
        $categoryObject = UnionCategory::find(['id_string' => $category]);
        $item->incViewCounter();
        // похожие статьи
        {
            $nearList = Article::getByTreeNodeIdQuery($categoryObject->getId())
                ->andWhere(['not in', 'id', $item->getId()])
                ->limit(3)
                ->all()
            ;
            if (count($nearList) == 0) {
                $nearList = Article::query()
                    ->select('id,header,id_string,image,view_counter,description,content')
                    ->orderBy(['date_insert' => SORT_DESC])
                    ->andWhere(['not in', 'id', $item->getId()])
                    ->limit(3)
                    ->all()
                ;
            }
        }

        return $this->render([
            'item'     => $item->getFields(),
            'category' => $category,
            'nearList' => $nearList,
            'breadcrumbs' => [
                'label' => $categoryObject->getField('header'),
                'url'   => '/category/' . $category,
            ],
        ]);
    }

    public function actionChenneling_item($year, $month, $day, $id)
    {
        $date = $year . $month . $day;
        $item = Chenneling::find([
            'date'      => $date,
            'id_string' => $id
        ]);
        if (is_null($item)) {
            throw new Exception('Нет такого послания');
        }
        $item->incViewCounter();
        // похожие статьи
        {
            $nearList = Chenneling::query()
                ->select('id,header,id_string,img,view_counter,description,content, date_insert')
                ->orderBy(['date_insert' => SORT_DESC])
                ->andWhere(['not in', 'id', $item->getId()])
                ->limit(3)
                ->all()
            ;
        }

        return $this->render([
            'item'     => $item->getFields(),
            'nearList' => $nearList,
        ]);
    }

    public function actionChenneling()
    {
        $cache = Application::cache(\app\models\Chenneling::MEMCACHE_KEY_LIST, function(BaseController $controller) {
            $itemsPerPage = 3 * 10;
            return $controller->renderFile('@app/views/page/chenneling_cache.php', [
                'items' => Chenneling::query()->orderBy(['date_insert' => SORT_DESC])->all(),
                'pages' => [
                    'list' => [],
                    'current' => 1,
                    'itemsPerPage' => $itemsPerPage
                ]
            ]);
        }, $this);

        return $this->render(['html' => $cache]);
    }
}
