<?php

/** @var array $articleList */

use yii\helpers\Url;


$this->title = 'Энергия';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>

        <p class="lead">В каждой точке вселенной находится сверхизбыток энергии, а значит на Земле присутствует
            Богатство Чистейшей Энергии.</p>

        <?php $this->registerJs("$('.carousel').carousel()"); ?>
        <div id="carousel-example-generic" class="carousel slide thumbnail" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="/images/page/energy/promo/slider/1.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/page/energy/promo/slider/3.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/page/energy/promo/slider/4.jpg" alt="...">
                </div>
                <div class="item">
                    <img src="/images/page/energy/promo/slider/5.jpg" alt="...">
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

        <div class="row">
            <div class="col-lg-4">
                <img src="/images/page/energy/promo/cvetok-life2.jpg" class="img-circle center-block" width="140" height="140"/>
                <h2 class="center-block text-center">Вечная батарея</h2>
                <p class="center-block text-center">Электрогенератор вырабатывает электроэнергию, не потребляя какого-либо топлива. Для выработки электроэнергии также нет необходимости во внешней энергии ветра, солнца, воды и т.п.</p>
            </div>
            <div class="col-lg-4">
                <img src="/images/page/energy/promo/f4.jpg" class="img-circle center-block" width="140" height="140"/>
                <h2 class="center-block text-center">Тихий</h2>
                <p class="center-block text-center">Уровень шума в момент регулирования<br> не более 30 дБ<br>для сравнения Тихий шепот	- 35 дБ, Спокойный разговор - 70 дБ</p>
            </div>
            <div class="col-lg-4">
                <img src="/images/page/energy/promo/f5.jpg" class="img-circle center-block" width="140" height="140"/>
                <h2 class="center-block text-center">Работает всегда</h2>
                <p class="center-block text-center">Время работы не ограничено. Расчетный срок службы от 10 лет</p>
            </div>
        </div>
        <a href="http://www.teslagen.org/" class="btn btn-success btn-lg" style="width: 100%; margin-bottom: 80px;">Узнать и купить</a>
        <hr>
    </div>


    <?= \app\services\GsssHtml::unionCategoryItems(7) ?>

    <div class="col-lg-12">
        <h2 class="page-header">Статьи</h2>
    </div>
    <?php foreach ($articleList as $item) {
        echo \app\services\GsssHtml::articleItem($item, 'energy');
    } ?>


    <div class="col-lg-12">
    <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/energy/promo/slider/1.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'В каждой точке вселенной находится сверхизбыток энергии, а значит на Земле присутствует
            Богатство Чистейшей Энергии.',
    ]) ?>
</div>
</div>