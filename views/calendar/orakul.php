<?php
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;
use yii\web\View;

$this->title = 'Оракул дня';

$this->registerJsFile('/js/pages/calendar/orakul.js', [
    'depends' => [
        'app\assets\App\Asset',
        'app\assets\Maya\Asset',
        'yii\web\JqueryAsset',
    ]
]);

$mayaAssetUrl = Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
$this->registerJs("var MayaAssetUrl='{$mayaAssetUrl}';", View::POS_HEAD);

$layoutAssetUrl = Yii::$app->assetManager->getBundle('app\assets\LayoutMenu\Asset')->baseUrl;
$this->registerJs("var LayoutAssetUrl='{$layoutAssetUrl}';", View::POS_HEAD);

?>

<div class="container">

<div class="col-lg-12">
    <h1 class="page-header"><?= $this->title ?></h1>
</div>
<style>
    .oracul .item {
        padding: 0px 10px 10px 10px;
        text-align: center;
    }

    #wave td {
        padding: 10px 20px 10px 10px;
        text-align: center;
    }
</style>

<div class="row">
<div class="col-lg-10">


<div class="col-lg-12">
    <div id="orakul-div" class="col-lg-4">
        <table id="orakul-table" class="oracul">
            <tr>
                <td></td>
                <td id="vedun" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td></td>
            </tr>
            <tr>
                <td id="antipod" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td id="today" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td id="analog" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
            </tr>
            <tr>
                <td></td>
                <td id="okkult" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <span style="color: #aaaaaa;">День:</span>
        <input type="text" id="day" class="form-control">
        <span style="color: #aaaaaa;">Месяц:</span>
        <select id="month" class="form-control">
            <option value="1">Январь</option>
            <option value="2">Февраль</option>
            <option value="3">Март</option>
            <option value="4">Апрель</option>
            <option value="5">Май</option>
            <option value="6">Июнь</option>
            <option value="7">Июль</option>
            <option value="8">Август</option>
            <option value="9">Сентябрь</option>
            <option value="10">Октябрь</option>
            <option value="11">Ноябрь</option>
            <option value="12">Декабрь</option>
        </select>
        <span style="color: #aaaaaa;">Год:</span>
        <input type="text" id="year" class="form-control">
        <span id="error" class="label-danger label"></span>
    </div>
</div>
<div class="col-lg-12">

<p>Волна</p>
<table id="wave">
    <tr>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
    </tr>
</table>
<hr>
<h2>Определение Оракула</h2>

<p>
    Прочтение Оракула Кина Судьбы или Кина дня – это передача импульса (переход на новый уровень сознания, новую
    частоту вибраций) и введение в космологию времени и синхронный планетарный порядок. </p>

<p>
    Свой тон и печать есть не только у человека, но и каждого года и у каждого дня, а также тон у месяца. Т.е.
    получается, что цикл находится в цикле, и мы проживаем сразу несколько энергий одновременно. </p>

<p>
    Каждый из 260 кинов имеет свой оракул. Оракул Кина - это энергии, которые описывают наше взаимодействие с
    другими кинами (людьми). Оракул судьбы – это 4 кина, оказывающие на Вас наибольшее воздействие. </p>

<p>
    Построение оракула помогает полнее осознать взаимосвязи кинов и открывает широкую перспективу исследования
    время-векторных потенциальностей. </p>

<p>
    Оракул Пятой Силы представляет взаимодействие 5-ти сил, отношения которых определяются цветом и кодовым числом
    печати кина.</p>

<p>Крест Оракула состоит из следующих печатей: </p>

<p>
    Центральную позицию всегда занимает Кин Судьбы (дня, года и т.д.). </p>

<p>
    Справа – АНАЛОГ, поддерживающая, стимулирующая, питающая сила, планетарный партнёр. </p>

<p>
    Сверху – ВЕДУЩИЙ (ведущая печать) – 5-я, результирующая сила, сила (энергия) результата, которая катализирует
    ясность и управляет проявленностью, дающая обертон и движение. Печать, корректирующая направление Вашего
    жизненного пути. </p>

<p>
    Слева – АНТИПОД, сила вызова и испытания, укрепляющая и балансирующая сила. Уравновешивание, мудрость. </p>

<p>
    Снизу – ОККУЛЬТНЫЙ УЧИТЕЛЬ – скрытая сила и её развитие, незримая духовная поддержка. </p>

<p>
    Каждый из 4-х основных цветов цветокодовой константы красный-белый-синий-жёлтый, при взаимодействии с 3-мя
    другими цветами образует соотношения: </p>

<p>
    Аналоговое: красный-белый и синий-жёлгый; </p>

<p>
    Антиподное: красный-синий и белый-желтый; </p>

<p>
    Оккультное: красный-желтый и белый-синий. </p>

<p>
    Таким образом, мы имеем 4 основные цвето-кодовые модели оракула. При этом печать Ведущего и кина дня всегда
    одного цвета. </p>

<p>
    Начнём расчёт оракула: </p>

<p>
    Сначала определим имена печатей оракула, используя простые формулы: </p>

<p>
    Возьмём, как пример, сегодняшний кин 195 – синий Космический Орёл. </p>

<p>
    Если N = кодовое число (порядковый номер печати) Кина Судьбы (дня), то: </p>

<p>
    Номер печати Аналога = 19 – N; </p>

<p>
    В примере: Синий Орёл-это 15 печать. 19 – 15 = 4. Смотрим по Цолькину, что 4 печать-это Жёлтое семя. Значит Жёлтое
    Семя-это Аналог Синего Орла </p>

<p>
    Номер печати Антипода = N+/-10, если печать с 0 (20) по 10, то «+10», а если с 11 по 19, то «-10»; </p>

<p>
    В примере: Синий Орёл, 15 – 10 = 5, 5 печать- это Красный Змей </p>

<p>
    Номер печати Оккультного = 21 – N; </p>

<p>
    В примере: 21 – 15 (Синий орёл) = 6, 6 печать – Белый Соединитель Миров. </p>

<p>
    А вот номер печати Ведущего зависит от тона Кина Судьбы, смотрим таблицу: </p>

<table class="table  table-striped" style="width: auto;">
    <tr>
        <th>
            печать
        </th>
        <th>
            расчет
        </th>
    </tr>
    <tr>
        <td style="padding-right: 40px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/1.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/6.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/11.gif" width="20">
        </td>
        <td>Та же печать</td>
    </tr>
    <tr>
        <td>
            <img src="<?= $mayaAssetUrl ?>/images/ton/2.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/7.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/12.gif" width="20">
        </td>
        <td>- 8 печатей</td>
    </tr>
    <tr>
        <td>
            <img src="<?= $mayaAssetUrl ?>/images/ton/3.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/8.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/13.gif" width="20">
        </td>
        <td>+ 4 печати</td>
    </tr>
    <tr>
        <td>
            <img src="<?= $mayaAssetUrl ?>/images/ton/4.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/9.gif" width="20">
        </td>
        <td>- 4 печати</td>
    </tr>
    <tr>
        <td>
            <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" width="20" style="margin-right: 10px;">
            <img src="<?= $mayaAssetUrl ?>/images/ton/10.gif" width="20">
        </td>
        <td>+ 8 печатей</td>
    </tr>
</table>

<p>
    В примере: У нас тон Космический, т.е. 13 тон, значит смотрим напротив 13 тона расчёт: </p>

<p>
    +4 печати. Считаем Орёл – 15 печать +4 = 19, 19 – это Буря. </p>

<p>
    Значит Ведущая печать сегодня Буря. </p>

<p>
    Теперь узнаем какие тона у наших печатей оракула. </p>

<p>
    Тон аналога, антипода и ведущего такой же, как у Кина Судьбы (кина дня), а тон оккультного = 14 - тон кина
    дня. </p>

<p>
    В примере: У нас сегодня Космический Орёл, а это 13 тон. </p>

<p>
    Нужно рассчитать только тон Оккультного: 14 – 13тон = 1 тон – Магнитный тон. </p>

<p>
    Итак, все расчёты сделаны: </p>

<p>
    Аналог – Космическое Жёлтое Семя </p>

<p>
    Антипод – Космический Красный Змей </p>

<p>
    Ведущая печать – Космическая Синяя Буря </p>

<p>
    Оккультный учитель - Магнитный Соединитель Миров. </p>

<p>
    Ещё один пример расчёта печатей Оракула: </p>

<p>
    Кин 200, Жёлтое Обертонное Солнце (печать 20, или 0; тон 5): </p>

<p>
    Аналог: 19 – 0 = 19, Синяя Буря; </p>

<p>
    Антипод: 0 + 10 = 10, Белая Собака; </p>

<p>
    Оккультный: 21 – 20 = 1, Красный Дракон; </p>

<p>
    Ведущий: 20 + 8 (т.к, тон Кина Судьбы чёрточный) = 8, Звезда </p>

<p>
    Можно для определения оракула использовать схемы потоков Оракула. </p>

<p>
    Подробнее: </p>

<p>
    Аналог - поддерживающая, питающая энергия. Аналоговый глиф отображает в символической форме вашего лучшего
    союзника. Этот глиф имеет больше общего с Вами чем любой из других, и люди, которые рождаются в эти дни будут
    естественными союзниками для Вас.&rdquo; </p>

<p>
    На двух вертикальных потоках аналоговый партнер всегда находится строго напротив Кина судьбы, т.к. они являются
    планетарными партнерами. </p>

<p>
    Перед тем, как начать рассказ об аналоговом взаимодействии, следует отметить, что оно идет на уровне печатей,
    лишь преобразуясь в зависимости от тонов творения. То есть аналог может быть полным, или истинным, то есть
    совпадающим по тону и печати (1 к 260) или просто по печати (1 к 20). </p>

<p>
    Итак, кто такой аналог и почему печати состоят в оракуле судьбы? Аналоговые печати (ваша печать и ваш аналог)
    всегда в сумме дают 19-Синюю Бурю, аналог Желтого Солнца, одну из самых мощных, в энергетическом плане, печатей.
    Это запуск беспрерывного процесса само-порождения этой энергии и катализа, ускорения, всех протекающих
    процессов. То есть это, в первую очередь, стимуляция, можно сказать, мотивация. Аналоговый партнер поддерживает
    Кин судьбы. </p>

<p>
    Но не стоит ожидать, что Вы будете в восторге от всего наследия своих аналогов. Реакция может быть и кардинально
    противоположной. Уверенным можно быть лишь в том, что равнодушны Вы не останетесь. Принцип воздействия
    определяется тоном творения аналога, эффект – суммарным (то есть это говорит о том, какая у вас получается
    Буря). </p>

<p>
    Антипод - испывающая, укрепляющая и балансирущая сила. Сложные отношения, необязательно плохие, но человек
    далекий от вас по сознанию и обязательно стокнетесь с испытаниями, дополнениями. </p>

<p>
    Услышав слово &ldquo;антипод&rdquo;, особенно при характеристике отношений с кем-то из близких, многие,
    уцепившись за приставку &ldquo;анти-&rdquo;, думают, что это что-то &ldquo;плохое&rdquo;. Но, в Дримспелл нет
    ничего плохого, также как и хорошего. Есть потенциалы энергий и их взаимодействий. Одним из которых является
    антиподная связь. </p>

<p>
    Антипод – это печать, находящаяся &ldquo;напротив&rdquo; вашей, симметрично ее отражая. </p>

<p>
    Пары цветов антиподных партнеров всегда красный и синий, белый и желтый. Кодовое число Кина судьбы всегда
    отстоит на 10 от кодового числа антиподного партнера. На двух вертикальных потоках антиподный партнер всегда
    находится радиально противоположно относительно Кина судьбы. У антиподов множество схожих черт, которые даны им
    неспроста. Это всегда представители одного семейства, у них всегда одинаковая ведущая чакра, следовательно,
    одинаковые системы ценностей, жизненных приоритетов и полное взаимопонимание с точки зрения духовной связи. Но,
    поскольку цвета их, т.к. они антиподы, противоположны (красный-синий, белый-желтый), способ достижения этих
    целей кардинально отличаются, то есть антипода прекрасно ладят между собой, но им сложно друг друга постичь,
    понять, что существует другой путь, не менее жизнеспособный, чем их личный. Антиподный партнер определяет вызов
    для Кина Судьбы. </p>

<p>
    В качестве наиболее очевидной парой антиподов можно привести Синего Орла и Красного Змея. Орел –
    обладатель &ldquo;планетарного разума&rdquo;, способности видения в широкой перспективе, с высоты птичьего
    полета. Змей же, наоборот, ближе всех к земле, он не обладает орлиным видением и движим по жизни своим чутьем,
    внутренним инстинктом. </p>

<p>
    В любом эволюционном цикле энергии обязательно проходят через состояние своего полного антипода, ведь нельзя
    постичь истинную мудрость, не поняв свою полную противоположность. </p>

<p>
    Оккультный Учитель – это носитель вашей скрытой силы, того свойства, развив которое вы придадите глубину и
    целостность силе своей печати. </p>

<p>
    Цветовое сочетание c учителем это белый-синий и краный-желтый. То есть холодные и теплые цвета. Соединяясь в
    пары он становятся еще теплее/холоднее. </p>

<p>
    Ваша печать в сумме с печатью учителя получается 21, то есть печать Дракона – знание. И действительно, общение с
    учителем проходит в формате обмена полезными друг для друга знаниями, ведь связь эта является двусторонней. </p>

<p>
    Это очень продуктивные и взаимовыгодные отношения. </p>

<p>
    Направляющий – Ведущий всегда имеет тот же цвет, что и Кин Судьбы. Это 5-я, результирующая сила, которая
    катализирует ясность и управляет проявленностью, дающая обертон и движение. Печать, корректирующая направление
    Вашего жизненного пути. </p>

<p>
    Закон для определения направляющих сил ежедневного Оракула Пятой Силы основывается на галактических тонах в их
    отношении к кодовому числу Кина судьбы. Галактический тон дня всегда находится на карте волнового модуля в
    ежедневной позиции галактического крыла. </p>

<p>
    Теперь о воздействии... Не обязательно общаться с человеком лично. Любое наследие несет в себе отпечаток автора.
    Это могут быть книги, музыка, любые формы искусства, кино, научные труды и практики. Вся прелесть этого метода,
    знакомства с оракулом, как раз и заключается в том, что Вы, не имея представлении о содержании, можете
    определить суть воздействия. </p>

<h2>Ноосферное время</h2>

<p>Согласно Закону Времени, время, как принцип четвёртого измерения, является фрактальным,
    радиальным и нелинейным. Всякий естественный природный и математический процесс имеет 4 фазы. Например, в
    суточном вращении Земли ключевыми точками являются точки полуночи (надира), восхода, полудня (зенита) и
    захода. </p>

<p>
    4 печати, окружающие в оракуле кин (будь то кин дня, Судьбы или года) также представляют циклический 4-х частный
    процесс. Так, в течение суток (года): </p>

<p>
    АНАЛОГ управляет периодом от полуночи до восхода (l четверть года); </p>

<p>
    ВЕДУЩИЙ управляет периодом от восхода до полудня (2 четверть года); </p>

<p>
    АНТИПОД управляет периодом от полудня до заката (3 четверть года); </p>

<p>
    ОККУЛЬТНЫЙ управляет периодом от заката до полуночи (4 четверть года). </p>

<p>
    В жизни, помимо нашего основного Кина Судьбы и Оракула Судьбы, мы в каждый свой день рождения, обретаем новый
    кин, новую энергию на целый год вперед. И зная его оракул, можем более осознанно и синхронично проживать каждый
    свой жизненный год. Обретение новой энергии помогает человеку прочувствовать все возможные виды энергий и
    выполнить свою основную задачу своего кина Судьбы. </p>

<p>
    Анализируя свой многомерный Кин Судьбы, исследуя свой Оракул, мы можем не только осознать свои уникальные
    духовно-психические составляющие, присущие нам от рождения, но и глубже понять кармические связи внутри родового
    древа, семьи. </p>

<p>
    Друзья могут быть следующих типов: </p>

<p>
    Полный двойник – совпадение по тону и печати </p>

<p>
    Тоновый двойник – совпадение по тону </p>

<p>
    Печатный двойник – совпадение по печати </p>

<p>
    Ведущий – ваша ведущая печать совпадает с его печатью судьбы, такой человек ведет вас в жизни </p>

<p>
    Аналог – ваша печать аналога совпадает с его печатью судьбы, такой человек является вашим аналогом и
    поддержкой </p>

<p>
    Антипод – ваша печать антипода совпадает с его печатью судьбы, такой человек является вашим антиподом и дает вам
    вызов </p>

<p>
    Оккультный учитель – ваша печать учителя совпадает с его печатью судьбы, такой человек незримая сила, которая
    подталкивает вас </p>

<p>
    Вы сами можете быть для друзей: </p>

<p>
    Ведущим – ведущая печать рассчитывается по специальной формуле </p>

<p>
    Аналогом – вы являетесь аналогом тем, кто для вас аналог </p>

<p>
    Антиподом – вы являетесь антиподом тем, кто для вас антипод </p>

<p>
    Оккультным учителем – вы являетесь оккультным учителем тем, кто для вас оккультным учителем </p>
</div>

</div>
<?= $this->render('_menu') ?>
</div>


</div>