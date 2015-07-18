<?php
use app\services\Page;
use yii\helpers\Url;

$this->title = 'Прощающая система';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Ошибок не существует. Закона не существует. Все есть непрерывное получение опыта и уроков для роста
            Духа в Любви и Прощении.</p>

        <p><img src="/images/page/forgive/-68GITqiv1c1.jpg" width="100%" class="thumbnail"></p>
    </div>


    <div class="col-lg-4">
        <div class="header" style="height: 70px;">
            <h3>Прощающая система</h3>
        </div>
        <p><img src="/images/page/forgive/10458817_666871636731987_1112058661082978933_n.jpg" width="100%"
                class="thumbnail"></p>

        <p>Существует в дополнение к судебной системе и является ее антиподом.</p>

        <p>Смысл ее в том что человек совершивший отклонение от истинного хода вещей (законов мироздания)
            прощается.</p>

        <p>Ему уделяется больше внимания и заботы, человек проходит центр позитивной психологии, где все его хвалят,
            показывают ему его лучшие стороны характера, его поступка и находят где он может применить свою силу и
            стороны характера наилучшим образом для блага общества и мира, где он может гармонично жить в
            содружестве с другими.</p>
    </div>
    <div class="col-lg-4">
        <div class="header" style="height: 70px;">
            <h3>Радикальное прощение</h3>
        </div>

        <p>                <a href="http://www.radikalnoe-p.ru/" target="_blank">

                <img src="/images/page/forgive/KVIOgmA3M281.jpg" width="100%" class="thumbnail">
            </a>
        </p>

        <p>«Радикальное прощение» – это эффективная техника избавления от неприятных переживаний прошлого и
            возвращения к радостной и счастливой жизни.</p>

        <p>Эта техника всего за несколько лет завоевала популярность во всем мире и на данный момент успешно
            применяется более чем в 43 странах земного шара.</p>

        <p>Начните избавляться от груза прошлого – застарелых обид и переживаний, неосознанных блоков и
            ограничивающих убеждений. Эти обиды и блоки притягивают одни и те же проблемы и не дают начать жить
            новой счастливой жизнью.</p>
    </div>
    <div class="col-lg-4">
        <div class="header" style="height: 70px;">
            <h3>Хо’опонопоно</h3>
        </div>

        <p>
            <a href="http://hooponoponosecret.ru/" target="_blank">
                <img src="/images/page/forgive/hoo.jpg" width="100%" class="thumbnail">
            </a>
        </p>

        <p>Хо’опонопоно – это древнее гавайское искусство решения проблем. В переводе с гавайского языка слово Хо’опонопоно означает «исправить ошибку» или «сделать верно».</p>
        <p>Хо’опонопоно помогает удалить, нейтрализовать и стереть деструктивные программы, чтобы стать единым с Божественным сознанием, которое присуще каждому человеку, слиться с потоком Изобилия и получить Вдохновение.</p>
    </div>

    <div class="col-lg-12">
        <h2 class="page-header">Объединения</h2>
    </div>

    <?= \app\services\GsssHtml::unionCategoryItems(8) ?>

    <div class="col-lg-12">
        <h2 class="page-header">Статьи</h2>
    </div>

    <?php foreach ($articleList as $item) {
        echo \app\services\GsssHtml::articleItem($item, 'forgive');
    } ?>


    <div class="col-lg-12">
    <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/forgive/-68GITqiv1c1.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'Ошибок не существует. Закона не существует. Все есть непрерывное получение опыта и уроков для роста
            Духа в Любви и Прощении.',
    ]) ?>
</div>
</div>