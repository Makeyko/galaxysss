<?php

use yii\widgets\Breadcrumbs;

/** @var \app\models\Service $item */

$this->title = $item->getField('header');

?>
<div class="container">
    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => 'Сервисы',
                'url'   => ['page/services'],
            ],
            $item->getField('header'),
        ],
    ]) ?>
    <div class="row">
        <div class="col-lg-4">
            <img class="img-thumbnail" src="<?= $item->getField('image') ?>">
        </div>
        <div class="col-lg-8">
            <?= $item->getField('content') ?>
            <?= \app\services\Page::linkToSite($item->getField('link')) ?>
        </div>
    </div>
</div>