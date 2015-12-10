<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $union_id int */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
    $('.rowTable').click(function() {
        window.location = '/cabinet/shop/requestList/' + $(this).data('id');
    });
JS
);
?>
<div class="container">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <?= \yii\grid\GridView::widget([
        'tableOptions' => [
            'class' => 'table tableMy table-striped table-hover',
        ],
        'rowOptions' => function($item) {
            return [
                'data' => ['id' => $item['id']],
                'role' => 'button',
                'class' => 'rowTable',
            ];
        },
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'      => \app\models\Shop\Request::query(['union_id' => $union_id])
            ->orderBy(['date_create' => SORT_DESC])
            ,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]),
        'columns' => [
            'id',
            [
                'header' => 'Клиент',
                'content' => function($item) {
                    $u = \app\models\User::find($item['user_id']);
                    $arr = [];
                    $arr[] = Html::tag('div', Html::img($u->getAvatar(), ['width' => 50, 'class' => 'thumbnail', 'style' => 'margin-bottom: 0px;']), ['class' => 'col-lg-4']);
                    $arr[] = Html::tag('div', $u->getEmail(), ['class' => 'col-lg-8']);
                    return join('', $arr);
                }
            ],
            'address',
            'comment',
            [
                'header' => 'Есть ответ?',
                'content' => function($item) {
                    $v = \yii\helpers\ArrayHelper::getValue($item, 'is_answer_from_client', 0);
                    if ($v == 0) return '';

                    return Html::tag('pre', null, ['class' => 'glyphicon glyphicon-envelope']);
                }
            ],
        ]
    ]) ?>
</div>
