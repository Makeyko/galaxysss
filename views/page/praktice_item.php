<?php

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Str;

/* @var $this yii\web\View */
/* @var $item array */
/* @var $lastList array */

$this->title = $item['header'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('#share').popover()");
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>

    <div class="col-lg-8" style="padding-bottom: 50px;">
        <?= $item['content'] ?>
        <hr>
        <?php if (isset($newsItem['source'])): ?>
            <?php if ($newsItem['source'] != ''): ?>
                <?= Html::a('Ссылка на источник »', $newsItem['source'], [
                    'class'  => 'btn btn-primary',
                    'target' => '_blank',
                ]) ?>
            <?php endif; ?>
        <?php endif; ?>
        <?= $this->render('../blocks/share', [
            'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($item['image'], true), false),
            'url'         => Url::current([], true),
            'title'       => $item['header'],
            'description' => trim(Str::sub($item['description'], 0, 200)),
        ]) ?>
        <!--                Комментарии -->
        <?//= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_NEWS, $item['id']); ?>

    </div>
    <div class="col-lg-4">
        <?php
        foreach ($lastList as $item) {
            ?>
            <div class="thumbnail">
                <a href="<?= \app\services\GsssHtml::getPrakticeUrl($item) ?>"><img
                        src="<?= $item['image'] ?>"
                        style="width: 100%; display: block;"
                        > </a>
                <div class="caption">
                    <h3>
                        <?= $item['header'] ?>
                    </h3>
                    <p>
                        <?= trim(Str::sub($item['description'], 0, 200)) ?>
                    </p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>