<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Лог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Simple columns defined by the data contained in $dataProvider.
            // Data from the model's column will be used.
            'id',
            'level',
            'category',
            [
                'header' => 'Время',
                'contentOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'content' => function ($model, $key, $index, $column) {
                    return Yii::$app->formatter->asDatetime((int)$model['log_time']); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            [
                'header' => 'Сообщение',
                'content' => function ($model, $key, $index, $column) {
                    return Html::tag('pre',$model['message']); // $data['name'] for array data, e.g. using SqlDataProvider.
                }
            ],
        ],
    ]) ?>

</div>