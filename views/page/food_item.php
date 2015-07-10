<?php

use yii\widgets\Breadcrumbs;

/** @var \app\models\Union $item */

$this->title = $item->getField('name');

?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Питание',
                    'url'   => ['page/food'],
                ],
                $item->getField('name'),
            ],
        ]) ?>

    </div>
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

    <?php

    if (count($officeList) > 0) {
        $g = new \app\services\GoogleMaps();
        $html = $g->map([
            'height'    => 400,
            'width'     => '100%',
            'pointList' => $officeList,
        ]);
        ?>
        <div class="col-lg-12">
            <h2 class="page-header">Представительства</h2>
            <?= $html ?>
        </div>
        <?php
    }
    ?>


</div>