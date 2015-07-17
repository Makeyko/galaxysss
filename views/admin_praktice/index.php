<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

$this->title = 'Практики';

$this->registerJsFile('/js/pages/admin_events/index.js', [
    'depends' => [
        'app\assets\App\Asset',
        'app\assets\ModalBoxNew\Asset'
    ]
]);
?>

<div class="container">
    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>


    <div class="col-lg-6">
        <?php
        $c = 1;
        foreach ($items as $item) {
            ?>
            <a href="<?= Url::to([
                'admin_praktice/edit',
                'id' => $item['id']
            ]) ?>" class="list-group-item" id="newsItem-<?= $item['id'] ?>">
                <h4><?= $item['header'] ?></h4>

                <div class="row">
                    <div class="col-lg-3">
                        <?php if ($item['image'] . '' != '') { ?>
                            <img src="<?= $item['image'] ?>" class="thumbnail" width="80">
                        <?php } ?>
                    </div>

                    <div class="col-lg-9">
                        <?= \cs\services\Str::sub(strip_tags($item['description']), 0, 200) . '...' ?>
                        <br> <br>
                        <button class="btn btn-danger btn-xs buttonDelete" data-id="<?= $item['id'] ?>">Удалить</button>
                        <?php if (\yii\helpers\ArrayHelper::getValue($item, 'is_added_site_update', 0) == 0) { ?>
                            <button class="btn btn-success btn-xs buttonAddSiteUpdate" data-id="<?= $item['id'] ?>">Сделать рассылку</button>
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
            <div class="btn-group">
                <a href="<?= Url::to(['admin_praktice/add']) ?>" class="btn btn-default">Добавить</a>
            </div>
        </div>
    </div>
</div>