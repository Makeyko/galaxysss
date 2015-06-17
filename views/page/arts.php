<?php

$this->title = 'Художники';

?>
<div class="container">
    <div class="page-header">
        <h1>Художники</h1>
    </div>
    <p class="lead">Художники рисуют миры в которых мы живем.</p>

    <p><img src="/images/page/arts/header.png" width="100%" class="thumbnail"></p>

    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(12) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'arts');
                } ?>
            </div>
        </div>
    <?php } ?>
</div>


