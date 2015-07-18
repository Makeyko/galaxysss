<?php

/** @var array  $articleList */

use yii\helpers\Url;


$this->title = 'Время';
?>
<div class="container">

    <div class="page-header">
        <h1>Время</h1>
    </div>
    <p class="lead">Когда время согласовано с ритмами природы, тогда мы можем мыслить в масштабах Вечности.</p>

    <p><img src="/images/page/time/2.jpg" width="100%" class="thumbnail"></p>

    <div class="row">
        <?php
        foreach(\app\models\UnionCategory::getRows(2) as $item) {
            echo \app\services\GsssHtml::unityCategoryItem($item);
        }
        ?>
        <?= \app\services\GsssHtml::unionCategoryItems(2) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'time');
                } ?>
            </div>
        </div>
    <?php } ?>


    <div class="col-lg-12">
        <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/time/2.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'Когда время согласовано с ритмами природы, тогда мы можем мыслить в масштабах Вечности.',
    ]) ?>

</div>
</div>