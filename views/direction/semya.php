<?php

/** @var array $articleList  */

use yii\helpers\Url;


$this->title = 'Семья';

?>

<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Семья</h1>

        <p class="lead">Семья целостна, гармонична и самодостаточна и вместе с этим излучает свою любовь всему окружающему в виде своих даров и талантов.</p>

        <?php $this->registerJs("$('.carousel').carousel()"); ?>
        <div id="carousel-example-generic" class="carousel slide thumbnail" data-ride="carousel" style="
    margin-bottom: 60px;
">
            <!-- Indicators -->

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="/images/direction/semya/0.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/direction/semya/1.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/direction/semya/2.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/direction/semya/3.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/direction/semya/6.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/direction/semya/4.jpg" alt="...">
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <p><a href="http://www.rod.galaxysss.com/" class="btn btn-success btn-lg" style="width: 100%">Агентство Сохранения Рода</a></p>
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

