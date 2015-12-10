<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Мои заказы';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
    $('.rowTable').click(function() {
        window.location = '/cabinet/order/' + $(this).data('id');
    });
JS
);
?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'      => \app\models\Shop\Request::query([
                    'user_id' => Yii::$app->user->id,
                ])
                ->andWhere(['not', ['in', 'status', [\app\models\Shop\Request::STATUS_FINISH_CLIENT, \app\models\Shop\Request::STATUS_FINISH_SHOP]]])
                ->orderBy(['date_create' => SORT_DESC])
            ,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]),
        'tableOptions' => [
            'class' => 'table table-hover table-striped',
        ],
        'rowOptions' => function($item) {
            return [
                'data' => ['id' => $item['id']],
                'role' => 'button',
                'class' => 'rowTable',
            ];
        },
        'columns' => [
            'id',
            [
                'header' => 'Объединение',
                'content' => function($item) {
                    $c = \app\models\Union::find($item['union_id']);

                    return (is_null($c))? '' : $c->getField('name');
                },
            ],
            [
                'header' => 'Статус',
                'content' => function($item) {
                    return  Html::tag('span',\app\models\Shop\Request::$statusList[$item['status']]['client'],[
                        'class' => 'label label-'.\app\models\Shop\Request::$statusList[$item['status']]['style']
                    ]);
                },
            ],
            'date_create:datetime',
            'comment',
            [
                'header' => 'Есть ответ?',
                'content' => function($item) {
                    $v = \yii\helpers\ArrayHelper::getValue($item, 'is_answer_from_shop', 0);
                    if ($v == 0) return '';

                    return Html::tag('pre', null, ['class' => 'glyphicon glyphicon-envelope']);
                }
            ],
        ]
    ]) ?>
</div>
