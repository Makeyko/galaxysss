<?php
$this->title = 'Питание';
?>
<div class="container">

    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>
    <p class="lead">В здоровом теле здоровый дух.</p>

    <p><img src="/images/page/food/51.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(4) ?>
    </div>
    <div class="row">
        <div class="page-header">
            <h2>Статьи</h2>
        </div>
        <div class="row">

            <?php foreach ($articleList as $item) {
                echo \app\services\GsssHtml::articleItem($item, 'food');
            } ?>
        </div>
    </div>
</div>