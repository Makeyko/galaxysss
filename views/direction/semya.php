<?php

/** @var array $articleList  */

use yii\helpers\Url;


$this->title = 'Семья';

?>

<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Семья</h1>

        <p class="lead">Мы строим мир одновременно во сферах жизни со скоростью мысли и по воле Бога.</p>

        <p><img src="/images/direction/index/header.jpg" width="100%" class="thumbnail"></p>
    </div>

    <?= \app\services\GsssHtml::unionCategoryItems(23) ?>


    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'semya');
        } ?>
    <?php } ?>


    <div class="col-lg-12">
        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => Url::to('/images/page/house/house.jpg', true),
            'url'         => Url::current([], true),
            'title'       => $this->title,
            'description' => 'Когда пространство выстраивается согласно сакральной геометрии и принципам золотого сечения, тогда
            оно несет силу и красоту.',
        ]) ?>
    </div>

</div>

