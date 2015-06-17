<?php

use yii\widgets\Breadcrumbs;

/** @var \app\models\Union $item */

$this->title = $item->getField('name');

?>
<div class="container">
    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>
    <?= Breadcrumbs::widget([
        'links' => [
            $breadcrumbs,
            $item->getField('name'),
        ],
    ]) ?>
    <div class="row">
        <div class="col-lg-4">
            <img class="img-thumbnail" src="<?= $item->getField('img') ?>">
        </div>
        <div class="col-lg-8">
            <div style="padding-bottom: 20px;">
                <?php
                if ($item->getField('content') . '' != '') {
                    echo $item->getField('content');
                }
                else {
                    echo $item->getField('description');
                }
                ?>
            </div>

            <?php
            if ($item->get('group_link_facebook') != '' || $item->get('group_link_vkontakte') != '' || $item->get('group_link_youtube') != '' || $item->get('group_link_google') != ''
            ) {
                ?>
                <div class="row">
                    <div class="page-header">
                        <h2>Ссылки на соцсети</h2>
                    </div>
                    <div class="col-lg-12">
                        <?php if ($item->get('group_link_facebook') != '') {
                            ?>
                            <p>facebook: <?= \yii\helpers\Html::a($item->get('group_link_facebook'), $item->get('group_link_facebook'),['target' => '_blank']) ?></p>
                        <?php
                        } ?>

                        <?php if ($item->get('group_link_vkontakte') != '') {
                            ?>
                            <p>vkontakte: <?= \yii\helpers\Html::a($item->get('group_link_vkontakte'), $item->get('group_link_vkontakte'),['target' => '_blank']) ?></p>
                        <?php
                        } ?>

                        <?php if ($item->get('group_link_youtube') != '') {
                            ?>
                            <p>youtube: <?= \yii\helpers\Html::a($item->get('group_link_youtube'), $item->get('group_link_youtube'),['target' => '_blank']) ?></p>
                        <?php
                        } ?>

                        <?php if ($item->get('group_link_google') != '') {
                            ?>
                            <p>google: <?= \yii\helpers\Html::a($item->get('group_link_google'), $item->get('group_link_google'),['target' => '_blank']) ?></p>
                        <?php
                        } ?>
                        <?= $html ?>
                    </div>
                </div>

            <?php
            }
            ?>
            <hr>

            <?= \app\services\Page::linkToSite($item->getField('link')) ?>

            <?= $this->render('../blocks/share', [
                'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(\yii\helpers\Url::to($item->getField('img'), true), false),
                'url'         => \yii\helpers\Url::current([], true),
                'title'       => $item->getField('name'),
                'description' => trim(\cs\services\Str::sub(strip_tags($item->getField('description')), 0, 200)),
            ]) ?>
        </div>
    </div>





    <?php

    if (count($officeList) > 0) {
        $g = new \app\services\GoogleMaps();
        $html = $g->map([
            'height'    => 400,
            'width'     => 900,
            'pointList' => $officeList,
        ]);
        ?>
        <div class="row">
            <div class="page-header">
                <h2>Представительства</h2>
            </div>
            <div class="col-lg-12">
                <?= $html ?>
            </div>
        </div>

    <?php
    }
    ?>


</div>