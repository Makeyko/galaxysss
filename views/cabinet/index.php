<?php
/** @var array $days */
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;

$this->registerJs("$('.js-stamp').tooltip()");

$dayInWeek = date('N') + 1;
if ($dayInWeek == 1) {
    $day = 0;
} else {
    $day = 7 - ($dayInWeek - 1);
}


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

    $html[] = Html::img(\Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl . "/images/stamp/{$d['stamp']}.jpg", [
        'height' => 40,
        'alt'    => \cs\models\Calendar\Maya::$stampRows[ $d['stamp'] - 1 ][0],
        'title'  => \cs\models\Calendar\Maya::$stampRows[ $d['stamp'] - 1 ][0],
        'class'  => 'js-stamp',
    ]);
    $html[] = Html::tag('span', $d['day'] . '.' . $d['month'], [
        'class' => 'js-stamp',
        'title' => GsssHtml::dateString($d['date']),
    ]);
    $html[] = Html::tag('br');
    $html[] = 'kin: ' . $d['kin'];
    $html[] = ($d['nearPortal'] == 0) ? 'п' : '';

    return join('', $html);
}


?>

<div class="container">

    <div class="page-header">
        <h1>Календарь</h1>
    </div>


    <style>
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
        }

        .calendar th img {
            height: 20px;
        }
    </style>
    <table class="calendar">
        <tr>
            <?php for ($i = 1; $i <= 7; $i++) { ?>
                <th><?= Html::img($mayaAssetUrl . "/images/plazma/{$i}.png") ?></th>
            <?php } ?>
        </tr>

        <?php
        do {
            $ost = $days[ $day + 0 ]['kin'] % 28;
            $nedelya = (int)($ost / 7);
            switch ($nedelya) {
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
                        <th><?= Html::img($mayaAssetUrl . "/images/plazma/{$i}.png") ?></th>
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