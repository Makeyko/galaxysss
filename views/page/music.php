<?php

$this->title = 'Музыка';

?>
<div class="container">
    <div class="page-header">
        <h1>Музыка</h1>
    </div>
    <p class="lead">Музыка высших сфер раскрывает сердца и расширяет сознание</p>

    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(13) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'music');
                } ?>
            </div>
        </div>
    <?php } ?>
</div>
