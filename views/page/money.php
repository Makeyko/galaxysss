<?php

use yii\helpers\Url;


$this->title = 'Деньги';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Деньги</h1>
        <p class="lead">Деньги – эквивалент вашей духовной силы и способности пропускать через себя большие потоки
            энергии.</p>

        <p><img src="/images/page/money/header.jpg" width="100%" class="thumbnail"></p>

        <?php $this->registerJs("$('.carousel').carousel()"); ?>
        <div id="carousel-example-generic" class="carousel slide thumbnail" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="/images/page/money/slider/img1.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/page/money/slider/img2.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/page/money/slider/img3.jpg" alt="...">
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

        <a href="http://www.capitalov.com/"
           class="btn btn-success btn-lg"
           style="width: 100%; margin-bottom: 80px;"
           target="_blank">Узнать и воспользоваться</a>
        <hr>

    </div>

    <div class="col-lg-4 unityItem">
        <div class="header">

            <h2>Стратегия эволюции</h2>

        </div>

        <p><img src="/images/page/money/CRhgPTeT8V8.jpg" width="100%" class="thumbnail"></p>

        <p>
            Внедрение единой мировой валюты Благодарность. То есть стоимость товаров и услуг будет исчисляться в количестве благодарности
            которую необходимо заплатить, чтобы получить данный товар и услугу и не остаться при этом кармическим должником.
            Переход от "Благодарности" к "Любви". То есть безвозмездное оказание услуг и товаров.
            Таким образом достигается совершенное изобилие. То етсть человек получает товар или услугу по его заслуге.
        </p>
    </div>
    <?= \app\services\GsssHtml::unionCategoryItems(6) ?>

    <?php if (count($articleList) > 0) { ?>

        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>

        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'money');
        } ?>

    <?php } ?>




    <div class="col-lg-12">
        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => Url::to('/images/page/money/laxmi.jpg', true),
            'url'         => Url::current([], true),
            'title'       => $this->title,
            'description' => 'Деньги – эквивалент вашей духовной силы и способности пропускать через себя большие потоки
                энергии.',
        ]) ?>
    </div>
</div>