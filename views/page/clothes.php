<?php
$this->title = 'Одежда';
?>
<div class="container">
    <div class="page-header">
        <h1>Одежда</h1>
    </div>
    <p class="lead">Одежда активирует энергетические центры и подчеркивает божественную красоту тела ангела.</p>

    <p><img src="/images/page/clothes/header2.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(9) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'clothes');
                } ?>
            </div>
        </div>
    <?php } ?>
</div>