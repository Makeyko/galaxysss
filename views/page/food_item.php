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
            [
                'label' => 'Питание',
                'url'   => ['page/food'],
            ],
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
            } else {
                echo $item->getField('description');
            }
            ?>
            </div>
            <?= \app\services\Page::linkToSite($item->getField('link')) ?>
        </div>
    </div>

    <?php

    if (count($officeList) > 0) {
        $g = new \app\services\GoogleMaps();
        $html = $g->map([
            'height' => 400,
            'width' => 900,
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