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
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <?= Breadcrumbs::widget([
            'links' => [
//                            $breadcrumbs,
                $item->getField('header'),
            ],
        ]) ?>
    </div>
    <div class="col-lg-4">
        <img class="img-thumbnail" src="<?= $item->getField('image') ?>">
    </div>
    <div class="col-lg-8">
        <div style="padding-bottom: 20px;">
            <?= $item->getField('content') ?>
        </div>
    </div>

    <?php if (count($unionList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Объединения</h2>
        </div>
        <?php foreach ($unionList as $item) {
            echo \app\services\GsssHtml::unionItem($item);
        } ?>
    <?php } ?>


    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, $idString);
        } ?>
    <?php } ?>

</div>