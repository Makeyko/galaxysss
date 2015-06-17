<?php

/** @var array $articleList */

$this->title = 'Энергия';
?>
<div class="container">

    <div class="page-header">
        <h1>Энергетика</h1>
    </div>
    <p class="lead">В каждой точке вселенной находится сверхизбыток энергии, а значит на Земле присутствует Богатство Чистейшей Энергии.</p>

    <p><img src="/images/page/energy/1405027_571610319578558_903459749_o1.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(7) ?>
    </div>
    <div class="row">
        <div class="page-header">
            <h2>Статьи</h2>

        </div>
        <div class="row">
            <?php foreach ($articleList as $item) {
                echo \app\services\GsssHtml::articleItem($item, 'energy');
            } ?>
        </div>
    </div>
</div>