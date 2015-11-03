<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

$this->title = 'Смета';

$this->registerJs(<<<JS
$('.buttonDelete').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите удаление')) {
            var b = $(this);
            var id = $(this).data('id');
            ajaxJson({
                url: '/admin/smeta/' + id + '/delete',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        b.parent().parent().remove();
                    });
                }
            });
        }
    });

JS
);
?>

<div class="container">
    <div class="page-header">
        <h1>Смета</h1>
    </div>

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
                    return Html::a(GsssHtml::getMiniText($item['target'], 70), ['admin_smeta/edit', 'id' => $item['id']]);
                }
            ],
            [
                'header' => 'Подарок',
                'content' => function($item) {
                    return Html::a(GsssHtml::getMiniText($item['present'], 70), ['admin_smeta/edit', 'id' => $item['id']]);
                }
            ],
            [
                'header' => 'Цена',
                'content' => function($item) {
                    return Yii::$app->formatter->asDecimal($item['price']);
                }
            ],
            [
                'header' => 'Счет',
                'content' => function($item) {
                    return GsssHtml::getMiniText($item['bill'], 70);
                }
            ],
            [
                'header' => 'Удалить',
                'content' => function($item) {
                    return Html::button('Удалить', [
                        'class' => 'btn btn-danger btn-xs buttonDelete',
                        'data-id' => $item['id'],
                    ]);
                }
            ],
        ]
    ])?>



    <div class="col-lg-6">
        <div class="row">
            <!-- Split button -->
            <div class="btn-group">
                <a href="<?= Url::to(['admin_smeta/add'])?>" class="btn btn-default">Добавить</a>

            </div>
        </div>
    </div>
</div>