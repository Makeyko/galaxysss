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

    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Simple columns defined by the data contained in $dataProvider.
            // Data from the model's column will be used.
            'id',
            [
                'label'   => 'level',
                'contentOptions' => [
                    'nowrap' => 'nowrap',
                ],
                'content' => function ($model, $key, $index, $column) {
                    switch($model['level']) {
                        case \yii\log\Logger::LEVEL_INFO: $type = 'INFO';    break;
                        case \yii\log\Logger::LEVEL_ERROR: $type = 'ERROR';    break;
                        case \yii\log\Logger::LEVEL_WARNING: $type = 'WARNING';    break;
                        case \yii\log\Logger::LEVEL_PROFILE: $type = 'PROFILE';    break;
                        case \yii\log\Logger::LEVEL_PROFILE_BEGIN: $type = 'PROFILE_BEGIN';    break;
                        case \yii\log\Logger::LEVEL_PROFILE_END: $type = 'PROFILE_END';    break;
                        default:  $type = ''; break;
                    }

                    return $type;
                }
            ],
            'category',
            [
                'label'   => 'date',
                'contentOptions' => [
                    'nowrap' => 'nowrap',
                ],
                'content' => function ($model, $key, $index, $column) {
                    return \Yii::$app->formatter->asDate((int)$model['log_time']);
                }
            ],
            [
                'label'   => 'time',
                'contentOptions' => [
                    'nowrap' => 'nowrap',
                ],
                'content' => function ($model, $key, $index, $column) {
                    $isViewMilliseconds = true;

                    $suffix = '';
                    if ($isViewMilliseconds) {
                        $decimal = $model['log_time'] - (int)$model['log_time'];
                        $suffix = substr($decimal, 1, 4);
                    }
                    return \Yii::$app->formatter->asTime((int)$model['log_time']) . $suffix;
                }
            ],
            [
                'header' => 'Сообщение',
                'content' => function ($model, $key, $index, $column) {
                    return Html::tag('pre', Html::encode($model['message'])); // $data['name'] for array data, e.g. using SqlDataProvider.
                }
            ],
        ],
    ]) ?>

</div>