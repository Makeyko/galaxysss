<?php

/** @var array $articleList */

$this->title = 'Энергия';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>

        <p class="lead">В каждой точке вселенной находится сверхизбыток энергии, а значит на Земле присутствует
            Богатство Чистейшей Энергии.</p>

        <p><img src="/images/page/energy/1405027_571610319578558_903459749_o1.jpg" width="100%" class="thumbnail"></p>
    </div>

    <?= \app\services\GsssHtml::unionCategoryItems(7) ?>

    <div class="col-lg-12">
        <h2 class="page-header">Статьи</h2>
    </div>
    <?php foreach ($articleList as $item) {
        echo \app\services\GsssHtml::articleItem($item, 'energy');
    } ?>
</div>