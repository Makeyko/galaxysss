<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

$this->title = 'Рассылки';


$urlSend = Url::to(['admin_subscribe/send']);
$urlDelete = Url::to(['admin_subscribe/delete']);
$this->registerJs(<<<JS
$('.buttonSend').click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    if (confirm('Подтвердите рассылку')) {
        var b = $(this);
        ajaxJson({
            url: '{$urlSend}',
            data: {
                id: b.data('id')
            },
            success: function(ret) {
                b.remove();
            }
        });
    }
});
$('.buttonDelete').click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    if (confirm('Подтвердите удаление')) {
        var b = $(this);
        ajaxJson({
            url: '{$urlDelete}',
            data: {
                id: b.data('id')
            },
            success: function(ret) {
                b.parent().parent().parent().remove();
            }
        });
    }
});
$('.buttonShow').click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    var b = $(this);
    window.location = b.data('url');
});
JS
);
?>

<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>


    <div class="col-lg-6">
        <?php
        $c = 1;
        foreach ($items as $item) {
            ?>
            <a href="<?= Url::to([
                    'admin_subscribe/edit',
                    'id' => $item['id']
                ]) ?>" class="list-group-item" id="newsItem-<?= $item['id'] ?>">
                <h4><?= $item['subject'] ?></h4>

                <div class="row">
                    <div class="col-lg-9">
                        <?= Html::tag('span', GsssHtml::dateString(date('Y-m-d',$item['date_insert'])), ['style' => 'font-size: 80%; margin-bottom:10px; color: #c0c0c0;']) ?>
                        <br>
                        <?= \cs\services\Str::sub(strip_tags($item['content']), 0, 200) . '...' ?>
                        <br>
                        <br>
                        <button class="btn btn-danger btn-xs buttonDelete" data-id="<?= $item['id'] ?>">Удалить</button>
                        <button class="btn btn-info btn-xs buttonShow" data-url="<?= Url::to(['admin_subscribe/view', 'id' => $item['id']]) ?>">Просмотреть</button>
                        <?php if (\yii\helpers\ArrayHelper::getValue($item, 'is_send', 0) == 0) { ?>
                            <button class="btn btn-success btn-xs buttonSend" data-id="<?= $item['id'] ?>">Разослать</button>
                        <?php } ?>
                    </div>
                </div>
            </a>
            <?php
            $c++;
        }?>
    </div>


    <div class="col-lg-6">
        <div class="row">
            <!-- Split button -->
            <div class="btn-group">
                <a href="<?= Url::to(['admin_subscribe/add'])?>" class="btn btn-success">Рассылка</a>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?= Url::to(['admin_subscribe/add_simple'])?>">Добавить только HTML</a></li>
                </ul></div>
        </div>
    </div>
</div>