<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Мои объединения';

$this->registerJs(<<<JS
        $('.buttonDelete').click(function (e) {
        if (confirm('Подтвердите удаление')) {
            e.preventDefault();
            e.stopPropagation();
            var id = $(this).data('id');
            var a = $(this).parent().parent();
            ajaxJson({
                url: '/objects/' + id + '/delete',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {

                    });
                }
            });
        }
    });

    // Отправить на модерацию
    $('.buttonSendModeration').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (confirm('Подтвердите свой выбор')) {
            var button = $(this);
            var id = $(this).data('id');
            var a = $(this).parent().parent();
            ajaxJson({
                url: '/objects/' + id + '/sendModeration',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {
                    });
                }
            });
        }
    });

    // Сделать рассылку
    $('.buttonAddSiteUpdate').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (confirm('Подтвердите')) {
            var buttonSubscribe = $(this);
            var id = $(this).data('id');
            ajaxJson({
                url: '/objects/' + id + '/subscribe',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        buttonSubscribe.remove();
                    });
                }
            });
        }
    });

    $('.rowTable').click(function() {
        window.location = '/objects/' + $(this).data('id') + '/edit';
    });
JS
);

$searchModel = new \app\models\Form\UnionSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get());


?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header">Мои объединения</h1>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-hover',
            ],
            'rowOptions'   => function ($item) {
                return [
                    'data'  => ['id' => $item['id']],
                    'role'  => 'button',
                    'class' => 'rowTable'
                ];
            },
            'columns'      => ArrayHelper::merge([
                'id',
                [
                    'header'  => 'Картинка',
                    'content' => function ($item) {
                        $i = ArrayHelper::getValue($item, 'img', '');
                        if ($i == '') return '';

                        return Html::img($i, [
                            'class' => "thumbnail",
                            'width' => 80,
                        ]);
                    }
                ],
                'name:text:Название',
                [
                    'header'  => 'Дата',
                    'content' => function ($item) {
                        return Html::tag('span', \app\services\GsssHtml::dateString($item['date_insert']), ['style' => 'font-size: 80%; margin-bottom:10px; color: #c0c0c0;']);
                    }
                ],
                [
                    'header'  => 'Удалить',
                    'content' => function ($item) {
                        return \yii\helpers\Html::button('Удалить', [
                            'class' => 'btn btn-danger btn-xs buttonDelete',
                            'data'  => [
                                'id' => $item['id'],
                            ]
                        ]);
                    }
                ],
                [
                    'header'  => 'Модерация',
                    'content' => function ($item) {
                        if ($item['moderation_status'] == 0) {
                            $arr[] = Html::tag('span', 'Отклонено модератором', ['class' => 'label label-danger']);
                            $arr[] = Html::tag('br');
                            $arr[] = Html::tag('br');
                            $arr[] = Html::button('Отправить на модерацию', [
                                'class'   => "btn btn-default btn-xs buttonSendModeration",
                                'data-id' => $item['id'],
                            ]);
                            return join('', $arr);
                        } else {
                            return '';
                        }
                    }
                ],

            ], (\Yii::$app->user->identity->isAdmin())?[
                [
                    'header'  => 'Рассылка',
                    'content' => function ($item) {
                        if (ArrayHelper::getValue($item, 'is_added_site_update', 0) == 0) {
                            return '';
                        }

                        return Html::button('Рассылка', [
                            'class' => 'btn btn-success btn-xs buttonAddSiteUpdate',
                            'data'  => [
                                'id' => $item['id'],
                            ]
                        ]);
                    }
                ]
            ]:[])
        ]) ?>
    </div>
</div>