<?php

use yii\widgets\Breadcrumbs;

/** @var \app\models\UnionCategory $item */
/** @var array $unionList */
/** @var array $articleList */
/** @var array $breadcrumbs */
/** @var string $idString кодовое название категории */

$this->title = $item->getField('header');

?>
<div class="container">
    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>
    <?= Breadcrumbs::widget([
        'links' => [
//            $breadcrumbs,
            $item->getField('header'),
        ],
    ]) ?>
    <div class="row">
        <div class="col-lg-4">
            <img class="img-thumbnail" src="<?= $item->getField('image') ?>">
        </div>
        <div class="col-lg-8">
            <div style="padding-bottom: 20px;">
                <?= $item->getField('content') ?>
            </div>
        </div>
    </div>

    <?php if (count($unionList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Объединения</h2>
            </div>
            <div class="row">
                <?php foreach ($unionList as $item) {
                    echo \app\services\GsssHtml::unionItem($item);
                } ?>
            </div>
        </div>
    <?php } ?>


    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, $idString);
                } ?>
            </div>
        </div>
    <?php } ?>

</div>