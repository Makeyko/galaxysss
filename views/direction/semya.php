<?php

/** @var array $articleList  */

use yii\helpers\Url;


$this->title = 'Семья';

?>

<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Семья</h1>

        <p class="lead">Семья целостна, гармонична и самодостаточна и вместе с этим излучает свою любовь всему окружающему в виде своих даров и талантов.</p>

        <p><img src="/images/direction/semya/header.jpg" width="100%" class="thumbnail"></p>
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
            'image'       => Url::to('/images/direction/semya/header.jpg', true),
            'url'         => Url::current([], true),
            'title'       => $this->title,
            'description' => 'Когда пространство выстраивается согласно сакральной геометрии и принципам золотого сечения, тогда
            оно несет силу и красоту.',
        ]) ?>
    </div>

</div>

