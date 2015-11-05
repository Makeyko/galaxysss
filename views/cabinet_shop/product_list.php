<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $union_id int */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => \app\models\Shop\Product::query()
                        ->select([
                            'gs_unions_shop_product.*'
                        ])
                        ->where(['gs_unions_shop_tree.union_id' => $union_id])
                        ->innerJoin('gs_unions_shop_tree', 'gs_unions_shop_tree.id = gs_unions_shop_product.tree_node_id')
                ,
              'pagination' => [
                  'pageSize' => 50,
              ],
            ]),
    ]) ?>
    <hr>
    <a href="<?= \yii\helpers\Url::to(['cabinet_shop/product_list_add', 'id' => $union_id]) ?>" class="btn btn-default">Добавить</a>
</div>
