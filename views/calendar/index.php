<?php
/** @var array $days */
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;

$this->title = 'Календарь';

$this->registerJs("$('.js-stamp').tooltip()");

$dayInWeek = date('N') + 1;
if ($dayInWeek == 1) {
    $day = 0;
} else {
    $day = 7 - ($dayInWeek - 1);
}

$dayWeekList = [
    'сб',
    'вс',
    'пн',
    'вт',
    'ср',
    'чт',
    'пт',
];

$kin = $days[0]['kin'];
$ost = $kin % 7;
if ($ost == 1) {
    $day = 0;
} else {
    $day = 7 - ($ost - 1);
}

$mayaAssetUrl = \Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
$countDays = count($days);

function drawItem($d)
{
    $html = [];

    $html[] = Html::img(\Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl . "/images/ton/{$d['ton']}.gif", [
        'width' => "23",
        'style' => "margin-left: 8px;",
        'class' => 'js-stamp',
        'title' => Maya::$tonList[ $d['ton'] ][0],
    ]);
    $html[] = Html::tag('br');
    $html[] = Html::img(\Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl . "/images/stamp/{$d['stamp']}.jpg", [
        'height' => 40,
        'alt'    => Maya::$stampRows[ $d['stamp'] - 1 ][0],
        'title'  => Maya::$stampRows[ $d['stamp'] - 1 ][0],
        'class'  => 'js-stamp',
    ]);
    $html[] = Html::tag('span', $d['day'] . '.' . $d['month'], [
        'class' => 'js-stamp dateGrisha',
        'title' => GsssHtml::dateString($d['date']),
    ]);
    $html[] = Html::tag('br');
    $html[] = Html::tag('span', 'kin', ['class' => 'kin']) . ': ' . $d['kin'];
    if ($d['nearPortal'] == 0) {
        $html[] = Html::tag('span', 'п', [
            'class' => 'js-stamp portal',
            'title' => 'Портал галактической активации',
        ]);
    }

    return join('', $html);
}

?>
<div class="container">

    <div class="page-header">
        <h1>Календарь</h1>
    </div>


    <style>
        .dateGrisha {
            padding-left: 5px;
        }

        .portal {
            padding-left: 5px;
            text-decoration: underline;
        }

        .kin {
            color: #cccccc;
        }

        .calendar td {
            height: 100px;
            text-align: left;
            vertical-align: middle;
            width: 130px;
            border-bottom: 1px solid #cccccc;
            padding: 0px 0px 0px 10px;
        }

        .calendar tr.red td {
            background-color: #fae0df;
        }

        .calendar tr.blue td {
            background-color: #d8eaf4;
        }

        .calendar tr.yellow td {
            background-color: #fef9db;
        }

        .calendar th {
            padding: 10px 10px 10px 20px;
            text-align: left;
            border-bottom: 1px solid #cccccc;
            font-weight: normal;
        }

        .calendar th img {
            height: 20px;
        }
    </style>

    <div class="row">
        <div class="col-lg-10">
            <table class="calendar">
                <tr>
                    <?php for ($i = 1; $i <= 7; $i++) { ?>
                        <th><?= Html::img($mayaAssetUrl . "/images/plazma/{$i}.png", [
                                'title' => \cs\models\Calendar\Maya::$plazmaRows[ $i ]['name'],
                                'class' => 'js-stamp',
                            ]) ?><br><?= $dayWeekList[ $i - 1 ] ?></th>
                    <?php } ?>
                </tr>

                <?php
                do {
                    $ost = $days[ $day + 0 ]['kin'] % 28;
                    $weekInt = (int)($ost / 7);
                    switch ($weekInt) {
                        case 0:
                            $week = 'red';
                            break;
                        case 1:
                            $week = 'white';
                            break;
                        case 2:
                            $week = 'blue';
                            break;
                        case 3:
                            $week = 'yellow';
                            break;
                    }
                    if ($week == 'red') {
                        // Пишу месяц какой сегодня
                        $month = (int)($days[ $day + 0 ]['kin'] / 28) + 1;
                        ?>
                        <tr class="month">
                            <td>
                                <?= Html::img($mayaAssetUrl . "/images/ton/{$month}.gif", ['width' => 40]) ?>
                            </td>
                            <td colspan="6">
                                Месяц: <?= $month ?>
                            </td>
                        </tr>
                        <tr>
                            <?php for ($i = 1; $i <= 7; $i++) { ?>
                                <th><?= Html::img($mayaAssetUrl . "/images/plazma/{$i}.png", [
                                        'title' => \cs\models\Calendar\Maya::$plazmaRows[ $i ]['name'],
                                        'class' => 'js-stamp'
                                    ]) ?><br><?= $dayWeekList[ $i - 1 ] ?></th>
                            <?php } ?>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr class="<?= $week ?>">
                        <td><?= drawItem($days[ $day + 0 ]) ?></td>
                        <td><?= drawItem($days[ $day + 1 ]) ?></td>
                        <td><?= drawItem($days[ $day + 2 ]) ?></td>
                        <td><?= drawItem($days[ $day + 3 ]) ?></td>
                        <td><?= drawItem($days[ $day + 4 ]) ?></td>
                        <td><?= drawItem($days[ $day + 5 ]) ?></td>
                        <td><?= drawItem($days[ $day + 6 ]) ?></td>
                    </tr>
                    <?php
                    $day += 7;
                } while ($day < ($countDays - 7));  ?>
            </table>

        </div>
        <div class="col-lg-2">
            <div class="list-group">
                <a href="<?= \yii\helpers\Url::to(['calendar/index']) ?>" class="list-group-item active">
                    По лунам
                </a>
                <a href="<?= \yii\helpers\Url::to(['calendar/colkin']) ?>" class="list-group-item">
                    Цолькин
                </a>
            </div>
        </div>
    </div>


</div>