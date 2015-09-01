<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $term string строка запроса */

$this->title = 'Результаты поиска';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">

    <h1 class="page-header">Результаты поиска</h1>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'      => \app\models\Chenneling::query(['like', 'header', $term])
            ->orWhere(['like', 'content', $term])
            ->select('id, img, header, date, id_string')
            ->orderBy(['date_insert' => SORT_DESC])
            ,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]),
        'columns'      => [
            [
                'class' => 'yii\grid\SerialColumn', // <-- here
                // you may configure additional properties here
            ],
            [
                'header'  => 'Картинка',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a(Html::img($model['img'], [
                        'width' => 40,
                        'class' => 'thumbnail',
                        'style' => 'margin-bottom: 0px;',
                    ]), ['page/chenneling_item',
                        'year'  => substr($model['date'], 0, 4),
                        'month' => substr($model['date'], 5, 2),
                        'day'   => substr($model['date'], 8, 2),
                        'id'    => $model['id_string'],
                    ]);
                }
            ],
            [
                'header'  => 'Название',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a( $model['header'], ['page/chenneling_item',
                        'year'  => substr($model['date'], 0, 4),
                        'month' => substr($model['date'], 5, 2),
                        'day'   => substr($model['date'], 8, 2),
                        'id'    => $model['id_string'],
                    ]);;
                }
            ],
        ]
    ]) ?>
</div>