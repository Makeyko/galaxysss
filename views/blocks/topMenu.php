<?php

use yii\helpers\Url;

?>

<li><a href="/mission">О нас</a></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">Сферы жизни <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">

        <li><a href="<?= Url::to(['page/language'])?>">Язык</a></li>
        <li><a href="<?= Url::to(['page/energy'])?>">Энергия</a></li>
        <li><a href="<?= Url::to(['page/time'])?>">Время</a></li>
        <li><a href="<?= Url::to(['page/house'])?>">Пространство</a></li>
        <li><a href="<?= Url::to(['page/study'])?>">Обучение</a></li>
        <li><a href="<?= Url::to(['page/forgive'])?>">Прощающая система</a></li>
        <li><a href="<?= Url::to(['page/money'])?>">Деньги</a></li>
        <li><a href="<?= Url::to(['page/medical'])?>">Здоровье</a></li>
        <li><a href="<?= Url::to(['page/food'])?>">Питание</a></li>

        <li class="divider"></li>

<!--    <li><a href="--><?//= Url::to(['page/idea'])?><!--">Идеологические группы</a></li>-->
        <li><a href="<?= Url::to(['page/tv'])?>">ТВ</a></li>
        <li><a href="<?= Url::to(['page/clothes'])?>">Одежда</a></li>
        <li><a href="<?= Url::to(['page/arts'])?>">Художники</a></li>
        <li><a href="<?= Url::to(['page/music'])?>">Музыка</a></li>

    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">Земля 4D <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">

        <li><a href="<?= Url::to(['page/declaration']) ?>">Декларация</a></li>
        <li><a href="<?= Url::to(['page/codex']) ?>">Кодекс</a></li>
        <li><a href="<?= Url::to(['page/residence']) ?>">Резиденция</a></li>

    </ul>
</li>

<li><a href="<?= Url::to(['page/chenneling']) ?>">Послания</a></li>
<li><a href="<?= Url::to(['page/news']) ?>">Новости</a></li>
<li><a href="<?= Url::to(['page/services']) ?>">Услуги</a></li>