<?php

/** $this \yii\web\View  */

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\services\GetArticle\Collection;

$this->title = 'Мои ченнелинги';

$this->registerJS(<<<JS

    $('.buttonDelete').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (confirm('Подтвердите удаление')) {
            var button = $(this);
            var id = $(this).data('id');
            ajaxJson({
                url: '/admin/chennelingList/' + id + '/delete',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        button.parent().parent().remove();
                    });
                }
            });
        }
    });

    // Сделать рассылку
    $('.buttonAddSiteUpdate').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (confirm('Подтведите свое намерение')) {
            var buttonSubscribe = $(this);
            var id = $(this).data('id');
            ajaxJson({
                url: '/admin/chennelingList/' + id + '/subscribe',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        buttonSubscribe.remove();
                    });
                }
            });
        }
    });

    $('.rowTable').click(function() {
        window.location = '/admin/chennelingList/' + $(this).data('id') + '/edit';
    });

JS
);
?>

<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        <div class="btn-group">
            <a href="<?= Url::to(['admin/chenneling_list_add']) ?>" class="btn btn-default">Добавить</a>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <?php foreach (Collection::getList() as $item) { ?>
                    <li><a href="<?= Url::to(['admin/chenneling_list_add_from_page', 'page' => $item['name']]) ?>">Добавить
                            с <?= $item['title'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query'      => \app\models\Chenneling::query()->orderBy(['date_insert' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]),
            'tableOptions' => [
                'class' => 'table table-striped table-hover',
            ],
            'rowOptions'   => function ($item) {
                return [
                    'data' => ['id' => $item['id']],
                    'role' => 'button',
                    'class' => 'rowTable'
                ];
            },
            'columns'      => [
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
                'header:text:Название',
                [
                    'header'  => 'Дата',
                    'content' => function ($item) {
                        return Html::tag('span', GsssHtml::dateString($item['date_insert']), ['style' => 'font-size: 80%; margin-bottom:10px; color: #c0c0c0;']);
                    }
                ],
                [
                    'header'  => 'Удалить',
                    'content' => function ($item) {
                        return Html::button('Удалить', [
                            'class' => 'btn btn-danger btn-xs buttonDelete',
                            'data'  => [
                                'id' => $item['id'],
                            ]
                        ]);
                    }
                ],
                [
                    'header'  => 'Рассылка',
                    'content' => function ($item) {
                        if (ArrayHelper::getValue($item, 'is_added_site_update',0) == 0) {
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
            ],
        ]) ?>

    </div>
</div>