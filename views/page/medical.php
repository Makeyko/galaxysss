<?php

$this->title = 'Союз самоисцеления';

?>
<div class="container">
<style>
    .headerUnion {
        height: 70px;
    }
</style>
    <div class="page-header">
        <h1>Союз самоисцеления</h1>
    </div>
    <p class="lead">Союз занимается восстанавлением
        здоровья, настраивает тело на резонанс с высшими контурами сознания, регулирует течение внутренних и внешних
        энергий человека.</p>

    <p><img src="/images/page/medical/parablev121.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(5) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'medical');
                } ?>
            </div>
        </div>
    <?php } ?>
</div>