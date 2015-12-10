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
        'tableOptions' => [
            'class' => 'table tableMy table-striped table-hover',
        ],
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'      => \app\models\Shop\Product::query(['union_id' => $union_id])
                ->select([
                    'id',
                    'name',
                    'image',
                ])
            ->orderBy(['sort_index' => SORT_ASC])
            ,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]),
        'columns' => [
            'id',
            [
                'header' => 'Картинка',
                'content' => function($item) {
                    $i = \yii\helpers\ArrayHelper::getValue($item, 'image', '');
                    if ($i == '') return '';
                    return Html::img($i, ['width' => 100]);
                }
            ],
            'name',
            [
                'header' => 'Редактировать',
                'content' => function($item) {
                    return Html::a('Редактировать', ['cabinet_shop/product_list_edit', 'id' => $item['id']], ['class' => 'btn btn-primary']);
                }
            ],
        ]
    ]) ?>
    <hr>
    <a href="<?= \yii\helpers\Url::to(['cabinet_shop/product_list_add', 'id' => $union_id]) ?>" class="btn btn-default">Добавить</a>
</div>
