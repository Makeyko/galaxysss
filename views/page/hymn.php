<?php
$this->title = 'Гимн мироздания';
?>

<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>

        <p class="lead">Весь Космос на защиту встал, Союз Галактики восстал! Чтоб возродилася Земля, В Любви с Любовью поднялась!</p>
    </div>


    <iframe width="100%" height="480" src="https://www.youtube.com/embed/EnzFP8-wmrE" frameborder="0" allowfullscreen></iframe>

    <p style="padding-top: 40px;">Всё, что сотворилось в Небесах,<br/>
        На Земле проявится.<br/>
        Будет Любовь могущество иметь,<br/>
        И с нею никому уже не справиться.</p>

    <p>Весь Космос на защиту встал,<br/>
        Союз Галактики восстал!<br/>
        Чтоб возродилася Земля,<br/>
        В Любви с Любовью поднялась!</p>

    <p>Пусть нескончаемым потоком<br/>
        Льётся изобилие Любви,<br/>
        Прекрасным, ярким истоком<br/>
        Проявится в Звёздной Дали!</p>

    <p>Пусть наша Земля расцветает,<br/>
        Галактик жемчужиной станет!<br/>
        Пусть опыт всего Мироздания<br/>
        В ней лучшую силу проявит! </p>

    <hr>

    <?= $this->render('../blocks/share', [
        'image'       => \yii\helpers\Url::to('/images/index/slider/5.jpg', true) ,
        'url'         => \yii\helpers\Url::current([], true),
        'title'       => $this->title,
        'description' => 'Весь Космос на защиту встал, Союз Галактики восстал! Чтоб возродилася Земля, В Любви с Любовью поднялась!',
    ]) ?>

</div>

