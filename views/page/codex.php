<?php
$this->title = 'Кодекс света';
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Новые правила для работников света</p>

        <p><img src="/images/page/codex/header.jpg" width="100%" class="thumbnail"></p>

        <p>Мастерами Света называют  тех людей, кто никогда, никого, ни в чём не обвинил; кто следует правилам Истины Божественного Творения; кто следует по пути свершения новых идей для построения Нового Мира на Земле; кто верит себе и Создателю.</p>

        <p>Жизнь на Земле — это подарок для души человека, для совершенствования всех его качеств. Вам, драгоценным Работникам Света, посвящается это послание. Вам внимать энергетику моих слов, вам дано это право.</p>

        <p>Сегодня я дам вам Новый Устав, Новые Правила вашей деятельности. Это Милость Божья изливается на вас, это Святой Дух вас боготворит, это новые Коды вашего совершенства. Читайте, анализируйте, размышляйте, принимайте сердцем. Вам открываются новые двери. В добрый путь!</p>

        <p>Любящий вас, Архангел Гавриил.</p>




        <p><img src="/images/page/codex/header2.jpg" width="100%" class="thumbnail"></p>
        <h2>Памятка работникам света</h2>
        <p>1. Соблюдать чистоту своих помыслов, несмотря на любые непредвиденные ситуации в жизни.</p>
        <p>2. Держать Свет своей души и нести его всему сущему на Земле.</p>
        <p>3. Соблюдать технику безопасности.</p>
        <p>— в медитациях и прочих духовных практиках</p>
        <p>— при сеансах творчества с Землёй</p>
        <p>— при проведении астрально-телепатических практик.</p>
        <p>4. Излучать Любовь своего сердечного пространства на всё окружающее вокруг вас.</p>
        <p>5. При общении со своими родными, друзьями, коллегами по работе — соблюдать спокойствие, позитивную волну.</p>
        <p>6. Никогда не употреблять в своём лексиконе слова «Я УСТАЛ(а),» никогда не говорите слов «Я НЕ МОГУ», «Я НЕ ХОЧУ».</p>
        <p>7. Трезво оценивайте свои жизненные уроки, извлекайте зерно истины.</p>
        <p>8. Смело шагайте путём познания всех жизненных ситуаций, определяя Божественный промысел по воспитанию вашей души.</p>
        <p>9. Изучайте новые знания в области системы Мироздания в новом потоке эволюционного пути.</p>



        <p><img src="/images/page/codex/header3.png" width="100%" class="thumbnail"></p>
        <h2>Кодекс мастера света</h2>
        <p>1. Следовать нормам и правилам этики гражданина Земли.</p>
        <p>2. Нести Свет души во всех её проявлениях открыто и любвеобильно, быть примером обществу.</p>
        <p>3. Твёрдо и уверенно шагать по своей тропе духовного развития.</p>
        <p>4. Соблюдать Золотые правила жизни, проявляя свою доброту, отзывчивость и лояльность.</p>
        <p>5. Разрешить себе быть хозяином своей жизни.</p>
        <p>6. С открытой душой выполнять своё предназначение в жизни.</p>
        <p>7. Быть примером в повседневной жизни, в любых ситуациях соблюдать спокойствие.</p>
        <p>8. Постоянно повышать свой духовный потенциал.</p>
        <p>9. Мастерски продолжать своё служение во благо всего сущего на Земле.</p>
        <p>10. Творить Новый мир на Земле во славу Создателя-Отца Небесного.</p>




        <p><img src="/images/page/codex/header4.jpg" width="100%" class="thumbnail"></p>
        <h2>Памятка для воина света</h2>
        <p>1. Если ты встал на путь Воина Света, твёрдо держи этот статус.</p>
        <p>2. Постоянно наполняйся новыми космическими энергиями посредством медитаций и творческих сеансов по работе с Землёй.</p>
        <p>3. Если в твоей жизни присутствуют элементы страха, удели внимание этому блоку, попросив помощи у своих Духовных Наставников и Учителей.</p>
        <p>4. Постоянно совершенствуй себя в применении своих навыков и умений.</p>
        <p>5. При любом энергетическом нападении, проявляй спокойствие, уверенность, твёрдость.</p>
        <p>6. Всегда помни о том, что ты находишься под защитой Небесного воинства.</p>
        <p>7. Смотри на Мир глазами Бога, не допускай изъянов на Земле.</p>
        <p>8. Приумножай вои задачи и с честью их выполняй, от этого ты будешь сильней.</p>
        <p>9. Не держи ни на кого обиды — это будет тебя стимулировать и держать твой статус Воина.</p>
        <p>10. Путь воина сложен и не лёгок. Выполняй его с честью во благо Мира на Земле.</p>
        <p style="margin-top: 40px;">Источник: <a href="http://tasachena.org/stranica-rabotnikov-sveta/">ссылка</a></p>


        <hr>

        <?= $this->render('../blocks/share', [
            'image'       => \yii\helpers\Url::to('/images/page/codex/header.jpg', true) ,
            'url'         => \yii\helpers\Url::current([], true),
            'title'       => $this->title,
            'description' => 'Новые правила для работников света',
        ]) ?>
    </div>

</div>