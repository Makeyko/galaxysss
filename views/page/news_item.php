<?php

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Str;

/* @var $this yii\web\View */
/* @var $newsItem array */

$item = $newsItem;
$this->title = $newsItem['header'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('#share').popover()");
?>
<div class="container">

    <div class="site-about">
        <div class="page-header">
            <h1><?= Html::encode($newsItem['header']) ?></h1>
        </div>

        <div class="content">

            <div class="col-lg-8">
                <?= $newsItem['content'] ?>
                <?php if (isset($newsItem['source'])): ?>
                    <?php if ($newsItem['source'] != ''): ?>
                        <?= Html::a('Ссылка на источник »', $newsItem['source'], [
                            'class'  => 'btn btn-primary',
                            'target' => '_blank',
                        ]) ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?= $this->render('../blocks/share', [
                    'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($item['img'], true), false),
                    'url'         => Url::current([], true),
                    'title'       => $item['header'],
                    'description' => trim(Str::sub(strip_tags($item['content']), 0, 200)),
                ]) ?>
                <!--                Комментарии -->
                <?= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_NEWS, $item['id']); ?>

            </div>
            <div class="col-lg-4">
                <?php
                foreach ($lastList as $item) {
                    ?>
                    <div class="row">
                        <div class="thumbnail">
                            <a href="<?= \app\services\GsssHtml::getNewsUrl($item) ?>"><img
                                src="<?= $item['img'] ?>"
                                style="width: 100%; display: block;"
                                > </a>

                            <div class="caption">
                                <h3>
                                        <?= $item['header'] ?>
                                </h3>

                                <p>
                                    <?= \app\services\GsssHtml::getMiniText($item['content']); ?>
                                </p>

                                <!--                                <p>-->
                                <!--                                    <a href="#"-->
                                <!--                                       class="btn btn-default"-->
                                <!--                                       role="button"-->
                                <!--                                        style="width: 100%"-->
                                <!--                                        >Button</a>-->
                                <!--                                </p>-->
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>

    </div>
</div>