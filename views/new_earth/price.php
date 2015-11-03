<?php
$this->title = 'Смета на «Новую Землю» по стандарту «Золотого Века»';
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Эскизный проект</p>


        <?= \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => \app\models\Smeta::query()->orderBy(['date_insert' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]),
            'columns' => [
                'id',
                [
                    'header' => 'Назначение',
                    'content' => function($item) {
                        return $item['target'];
                    }
                ],
                [
                    'header' => 'Подарок',
                    'content' => function($item) {
                        return $item['present'];
                    }
                ],
                [
                    'header' => 'Цена, тыс руб',
                    'content' => function($item) {
                        return Yii::$app->formatter->asDecimal($item['price'], 0);
                    }
                ],
                [
                    'header' => 'Счет',
                    'content' => function($item) {
                        return $item['bill'];
                    }
                ],
            ]
        ])?>


        <hr>

        <?= $this->render('../blocks/share', [
            'image'       => \yii\helpers\Url::to('/images/new_earth/codex/header.jpg', true) ,
            'url'         => \yii\helpers\Url::current([], true),
            'title'       => $this->title,
            'description' => 'Смета на «Новую Землю» по стандарту «Золотого Века». Эскизный проект',
        ]) ?>
    </div>

</div>