<?php
$this->title = 'Время';
?>
<div class="container">

    <div class="page-header">
        <h1>Время</h1>
    </div>
    <p class="lead">Когда время согласовано с ритмами природы, тогда мы можем мыслить в масштабах Вечности.</p>

    <p><img src="/images/page/time/3406595251.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(2) ?>
    </div>
    <div class="row">
        <div class="page-header">
            <h2>Статьи</h2>
        </div>
        <div class="row">
            <?php foreach ($articleList as $item) {
                echo \app\services\GsssHtml::articleItem($item, 'language');
            } ?>
        </div>

    </div>

</div>