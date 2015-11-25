<?php

namespace app\controllers;

use app\models\Article;
use app\models\Praktice;
use app\models\Service;
use app\models\Shop\Product;
use app\models\Shop\TreeNode;
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
use yii\helpers\ArrayHelper;
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
use yii\db\Query;


class Union_shopController extends BaseController
{
    public $layout = 'menu';

    /**
     * Главная страница магазина
     *
     * @param $category string id_string
     * @param $id int идентификатор объединения
     *
     * @return string
     * @throws \cs\web\Exception
     */
    public function actionIndex($category, $id)
    {
        $item = Union::find($id);
        if (is_null($item)) {
            throw new Exception('Нет такого объединения');
        }

        $categoryObject = UnionCategory::find(['id_string' => $category]);
        if (is_null($categoryObject)) {
            throw new Exception('Не найдена категория');
        }
        $breadcrumbs = $categoryObject->getBreadCrumbs();
        $breadcrumbs = ArrayHelper::merge($breadcrumbs, [
            [
                'url'   => ['page/union_item', 'id' => $item->getId(), 'category' => $categoryObject->getField('id_string')],
                'label' => $item->getName(),
            ],
            'Магазин'
        ]);
        $rows = $this->getRows(TreeNode::query(['parent_id' => null])->select('id')->scalar(), $item->getId());

        return $this->render([
            'union'       => $item,
            'shop'        => $item->getShop(),
            'breadcrumbs' => $breadcrumbs,
            'rows'        => $rows,
            'category'    => $categoryObject,
        ]);
    }

    /**
     * Категория с товарами
     *
     * @param $category string id_string
     * @param $id int идентификатор объединения
     * @param $shop_category int идентификатор категории gs_unions_shop_tree.id
     *
     * @return string
     * @throws \cs\web\Exception
     */
    public function actionCategory($category, $id, $shop_category)
    {
        $item = Union::find($id);
        if (is_null($item)) {
            throw new Exception('Нет такого объединения');
        }

        $categoryObject = UnionCategory::find(['id_string' => $category]);
        if (is_null($categoryObject)) {
            throw new Exception('Не найдена категория');
        }
        $treeNode = TreeNode::find($shop_category);

        $breadcrumbs = $categoryObject->getBreadCrumbs();
        $breadcrumbs = ArrayHelper::merge($breadcrumbs, [
            [
                'url'   => ['page/union_item', 'id' => $item->getId(), 'category' => $categoryObject->getField('id_string')],
                'label' => $item->getName(),
            ],
            [
                'url'   => ['union_shop/index', 'id' => $item->getId(), 'category' => $categoryObject->getField('id_string')],
                'label' => 'Магазин',
            ],
            $treeNode->getField('name'),
        ]);

        return $this->render([
            'union'       => $item,
            'shop'        => $item->getShop(),
            'breadcrumbs' => $breadcrumbs,
            'category'    => $categoryObject,
            'items'       => Product::query([
                'moderation_status' => 1,
                'tree_node_id'      => $treeNode->getId(),
            ])->orderBy(['sort_index' =>SORT_ASC])->all(),
        ]);
    }

    /**
     * Возвращает элементы списка
     * @return array
     * [[
     *  'id' =>
     *  'name' =>
     *  'nodes' => array
     * ], ... ]
     */
    public function getRows($parentId, $union_id)
    {
        $rows = (new Query())
            ->select('id, name')
            ->from(TreeNode::TABLE)
            ->where([
                'parent_id' => $parentId,
                'union_id'  => $union_id,
            ])
            ->orderBy(['sort_index' => SORT_ASC])
            ->all();
        for ($i = 0; $i < count($rows); $i++) {
            $item = &$rows[ $i ];
            $rows2 = $this->getRows($item['id'], $union_id);
            if (count($rows2) > 0) {
                $item['nodes'] = $rows2;
            }
        }

        return $rows;
    }

}
