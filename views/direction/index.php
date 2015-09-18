<?php


$this->title = 'Сферы жизни';

$isMobile = \Yii::$app->deviceDetect->isMobile();

?>

<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Сферы жизни</h1>

        <p class="lead">Мы строим мир одновременно во сферах жизни со скоростью мысли и по воле Бога.</p>

        <p><img src="/images/direction/index/header.jpg" width="100%" class="thumbnail"></p>
    </div>



    <div class="col-lg-12">
        <?php if ($isMobile) { ?>
            <div class="list-group">
                <a class="list-group-item" href="/language">Язык</a>
                <a class="list-group-item" href="/energy">Энергия</a>
                <a class="list-group-item" href="/time">Время</a>
                <a class="list-group-item" href="/house">Пространство</a>
                <a class="list-group-item" href="/study">Обучение</a>
                <a class="list-group-item" href="/forgive">Прощающая система</a>
                <a class="list-group-item" href="/money">Деньги</a>
                <a class="list-group-item" href="/medical">Здоровье</a>
                <a class="list-group-item" href="/food">Питание</a>
            </div>
        <?php } else { ?>
            <p class="text-center"><img
                    src="/images/page/mission/1415014_551550491597436_590146424_o.jpg"
                    usemap="#Map"
                    width="610"
                    title="Выберите интересующую вас сферу жизни"
                    id="imageSfera"
                    data-toggle="tooltip" data-placement="right"
                    ></p>
            <map name="Map" id="Map">
                <area shape="poly" coords="319,122,345,131,335,185,304,181" href="/language" alt="Язык">
                <area shape="poly" coords="382,226,443,166,461,191,402,245" href="/energy" alt="Энергия">
                <area shape="poly" coords="421,293,488,293,489,316,422,319" href="/time" alt="Время">
                <area shape="poly" coords="385,356,482,439,453,455,359,380" href="/house" alt="Пространство">
                <area shape="poly" coords="300,422,341,409,359,499,322,507" href="/study" alt="Обучение">
                <area shape="poly" coords="226,378,282,416,227,509,168,477" href="/forgive" alt="Прощающая система">
                <area shape="poly" coords="105,358,193,328,201,357,121,386" href="/money" alt="Деньги">
                <area shape="poly" coords="116,223,213,255,198,283,101,255" href="/medical" alt="Здоровье">
                <area shape="poly" coords="213,129,273,198,222,219,184,145" href="/food" alt="Питание">
            </map>
        <?php } ?>



        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => \yii\helpers\Url::to('/images/direction/index/header.jpg', true),
            'url'         => \yii\helpers\Url::current([], true),
            'title'       => $this->title,
            'description' => 'Мы строим мир одновременно во сферах жизни со скоростью мысли и по воле Бога.',
        ]) ?>

    </div>

</div>

