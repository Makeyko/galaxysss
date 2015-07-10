<?php
$this->title = 'Одежда';
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Одежда активирует энергетические центры и подчеркивает божественную красоту тела ангела.</p>

        <p><img src="/images/page/clothes/header2.jpg" width="100%" class="thumbnail"></p>
    </div>

    <?= \app\services\GsssHtml::unionCategoryItems(9) ?>

    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'clothes');
        } ?>
    <?php } ?>
</div>