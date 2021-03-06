<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ТелеВидение';

$data = [
    [
        'Баланс ТВ',
        'http://www.balance-tv.ru/',
        '/images/page/tv/12653_411905642248496_248431441_n.png',
        'ТВ БАЛАНС — это окно в духовный мир: в мир вечности, знания и блаженства! Телевидение 21 века, основанное на принципах чистоты, культуры, разума',
    ],
    [
        'Ради Мира ТВ',
        'https://www.facebook.com/RadiMiraTv',
        '/images/page/tv/977421_288052577997726_268410364_o.png',
        'РадиМира.ТВ — современное общественное интернет телевидение для тех, кто хочет развиваться, созидать и двигаться за пределы известного!',
    ],
    [
        'Датта Медиа Групп',
        'http://dattamedia.ru/',
        '/images/page/tv/datta.jpg',
        'ДАТТА МЕДИА Групп  — это медийный проект, собирающий под своей эгидой профессиональные медиа сообщества, объединенные общей целью — проявлять культурное пространство принципиально нового качества.
Ядро нашей команды – не просто единомышленники, но люди, много лет занимающиеся духовными практиками, изучающие философию и истоки своей древнейшей истории, которые видят смысл в служении Просветляющей Силе в сфере культуры и искусства. Под термином ‘Просветляющая сила’ подразумевается Путь развития сознания человека, в сторону утончения, силы, ясности и раскрытия своих истинных потенциалов.',
    ],
    [
        'Психология 21',
        'http://www.tv-stream.ru/tv/psikhologiya-21',
        '/images/page/tv/psiho.jpg',
        '«ПСИХОЛОГИЯ21» предлагает и помогает зрителю вернуться к главному – к себе самому, к своему не всегда гармонично устроенному внутреннему миру, скорректировать собственные обстоятельства, чтобы не стать жертвой бесконечных условностей и зачастую бессмысленной погони за формальными признаками внешнего успеха.
Художественному руководителю телеканала Эдуарду Сагалаеву удалось собрать сильную команду единомышленников. Среди партнеров канала – Ассоциация трансперсональной психологии и психотерапии, Международная ассоциация личностного роста, Институт психотерапии и клинической психологии Елены Гордеевой, Институт клинического гипноза, Фонд «Трансперсональная психология», Институт Групповой и Семейной Психотерапии.',
    ],
    [
        'Радомир ТВ',
        'http://radomir.tv/',
        '/images/page/tv/1rdv.jpg',
        'РАДОМИР – это команда профессионалов, помогающая вам расти и достигать успеха. Нести в мир свет и радость – глубокий код, зашифрованный в славянском имени Радомир. Это слово - светоч знания и просветления, любви, радости и тепла. Ведь жить в здравом сознании, здоровье, счастье и гармонии – естественное состояние для человека. Это благодать, данная природой и Богом, каждому живущему на Земле. Просвещать и развивать, помогать и направлять, открывать новые возможности, радовать и дарить - вот цель нашего видеоканала «Радомир».  В этом нам помогают лучшие мастера и тренеры счастья, успеха, взаимоотношений, здоровья и бизнеса. Своим опытом достижения гармонии делятся самые успешные люди.',
    ],
    [
        'Сайт Преображение',
        'https://www.youtube.com/channel/UCenrBsE2KlLoOUkroD6UI_Q',
        '/images/page/tv/hDFGpcvW7og1.jpg',
        'Мы являемся теми, кто проводит энергии Христа, божественные энергии Христосознания в материальный мир и меняет парадигму существования сознания и реальности на этой прекрасной планете. Наша цель и единственное искреннее желание состоит в том, чтобы оказать помощь тем, кто встал на путь познания себя истинного, кто ищет ответы на вопрос: кто мы и откуда, зачем и почему тут родились.Ответы на эти вопросы не так сложны, как может показаться, но важным является то, что каждый должен пройти свой уникальный путь осознаний и личного опыта, чтобы получить ответы на эти вопросы. Ибо сам путь и его опыт намного важнее самого ответа. Это и есть смысл жизни -- опыт поиска себя истинного и осознанное возвращение к своим божественным Истокам...',
    ],
    [
        'Познавательное ТВ',
        'http://poznavatelnoe.tv/',
        '/images/page/tv/1222.png',
        'Познавательное телеыидение',
    ],
    [
        'АРИ ТВ',
        'http://ari.ru/tv?page=6',
        '/images/page/tv/ari.jpg',
        'Агенство Русской Информации',
    ],
    [
        'Арканум ТВ',
        'http://www.mag-project.ru/',
        '/images/page/tv/arcanum.png',
        'Центр развития личности Алексея Похабова. Видео портал победителя 7й битвы экстрасенсов на ТНТ Алексея Похабова.
В данных видео вы получите магические ключи от эзотерических знаний.
- Этот портал о раскрытии собственно магической природы.
- Этот портал о том, как быть счастливым и наслаждаться жизнью.
- Этот портал о поиске своего пути и умении извлекать из него знания',
    ],

];

function draw($item)
{
    $html = [];
    $html[] = Html::tag('h2', $item[0]);
    $html[] = Html::tag('p', Html::a(Html::img($item[2], ['class' => "thumbnail", 'width' => "100%"]), $item[1], ['target' => '_blank']));
    $html[] = Html::tag('p', $item[3]);

    return Html::tag('div', join('', $html), ['class' => "col-lg-4"]);
}

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Новое прогрессивное телевидение открывающее новые горизонты восприятия мира и обучающее счастью, любви и радости
            жизни.</p>
        <p><img src="/images/page/time/3406595251.jpg" width="100%" class="thumbnail"></p>
    </div>


    <div class="row">
        <?php
        foreach ($data as $item) {
            echo draw($item);
        }
        ?>
        <?= \app\services\GsssHtml::unionCategoryItems(10) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'tv');
        } ?>
    <?php } ?>



    <div class="col-lg-12">
    <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/time/3406595251.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'Новое прогрессивное телевидение открывающее новые горизонты восприятия мира и обучающее счастью, любви и радости
            жизни.',
    ]) ?>

</div>
</div>