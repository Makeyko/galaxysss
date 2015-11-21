<?php

use yii\helpers\Url;

?>

<li><a href="/mission">О нас</a></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">Сферы жизни <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">

        <li><a href="<?= Url::to(['direction/index']) ?>">Все</a></li>

        <li class="divider"></li>

        <li><a href="<?= Url::to(['page/language']) ?>">Язык</a></li>
        <li><a href="<?= Url::to(['page/energy']) ?>">Энергия</a></li>
        <li><a href="<?= Url::to(['page/time']) ?>">Время</a></li>
        <li><a href="<?= Url::to(['page/house']) ?>">Пространство</a></li>
        <li><a href="<?= Url::to(['page/study']) ?>">Обучение</a></li>
        <li><a href="<?= Url::to(['page/forgive']) ?>">Прощающая система</a></li>
        <li><a href="<?= Url::to(['page/money']) ?>">Деньги</a></li>
        <li><a href="<?= Url::to(['page/medical']) ?>">Здоровье</a></li>
        <li><a href="<?= Url::to(['page/food']) ?>">Питание</a></li>

        <li class="divider"></li>

        <!--    <li><a href="--><? //= Url::to(['page/idea'])?><!--">Идеологические группы</a></li>-->
        <li><a href="<?= Url::to(['page/tv']) ?>">ТВ</a></li>
        <li><a href="<?= Url::to(['page/clothes']) ?>">Одежда</a></li>
        <li><a href="<?= Url::to(['page/arts']) ?>">Художники</a></li>
        <li><a href="<?= Url::to(['page/music']) ?>">Музыка</a></li>

        <li class="divider"></li>

        <li><a href="<?= Url::to(['direction/semya']) ?>">Семья</a></li>

    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">Земля 4D <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">

        <li><a href="<?= Url::to(['new_earth/index']) ?>">Введение</a></li>
        <li class="divider"></li>
        <li><a href="<?= Url::to(['new_earth/declaration']) ?>">Декларация</a></li>
        <li><a href="<?= Url::to(['new_earth/manifest']) ?>">Манифест</a></li>
        <li><a href="<?= Url::to(['new_earth/codex']) ?>">Кодекс</a></li>
        <li><a href="<?= Url::to(['new_earth/residence']) ?>">Резиденция</a></li>
        <li><a href="<?= Url::to(['new_earth/chakri']) ?>">Карта чакр</a></li>
        <li><a href="<?= Url::to(['new_earth/hymn']) ?>">Гимн</a></li>
        <li><a href="<?= Url::to(['new_earth/history']) ?>">История Человечества</a></li>
        <li><a href="<?= Url::to(['new_earth/kon']) ?>">Законы</a></li>
        <li><a href="<?= Url::to(['new_earth/price']) ?>">Смета</a></li>

    </ul>
</li>

<li<?php if ((Url::to(['page/chenneling']) == Url::current()) or (Yii::$app->controller->action->id == 'chenneling_item')) {
    echo ' class="active"';
} ?>><a href="<?= Url::to(['page/chenneling']) ?>">Послания</a></li>
<li<?php if ((Url::to(['page/news']) == Url::current()) or (Yii::$app->controller->action->id == 'news_item')) {
    echo ' class="active"';
} ?>><a href="<?= Url::to(['page/news']) ?>">Новости</a></li>

<?php if (!\Yii::$app->user->isGuest) { ?>
    <?php
    $c = \app\services\SiteUpdateItemsCounter::getValue();
    $this->registerJs("$('#linkUpdates').tooltip({placement:'right'})");
    if ($c > 0) {
        $class = 'danger';
    } else {
        $class = 'default';
    }
    ?>
    <li>
        <a href="<?= Url::to(['site/site_update']) ?>">
            <span title="Обновления" id="linkUpdates" class="label label-<?= $class ?>">
                <?= $c ?>
            </span>
        </a>
    </li>
<?php } ?>


<li<?php if ((Url::to(['page/services']) == Url::current()) or (Yii::$app->controller->action->id == 'services_item')) {
    echo ' class="active"';
} ?>><a href="<?= Url::to(['page/services']) ?>">Услуги</a></li>
<li<?php if ((Url::to(['calendar/events']) == Url::current()) or (Yii::$app->controller->action->id == 'events_item')) {
    echo ' class="active"';
} ?>><a href="<?= Url::to(['calendar/events']) ?>">События</a></li>
<li<?php if ((Url::to(['page/blog']) == Url::current()) or (Yii::$app->controller->action->id == 'blog_item')) {
    echo ' class="active"';
} ?>><a href="<?= Url::to(['page/blog']) ?>">Блог</a></li>