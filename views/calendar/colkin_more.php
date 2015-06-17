<?php
/** @var $this yii\web\View */
/** @var array $days двумерный массив [строка от 1][колонка от 1]
 * [
 * 'ton' => int от 1
 * 'kin' => int от 1
 * 'stamp' => int от 1
 * 'isPortal' => bool
 * 'day' => int
 * 'month' => int
 * 'year' => int
 * ]
 */

use cs\models\Calendar\Maya;
use app\services\GsssHtml;
use yii\helpers\Url;

$mayaAssetUrl = \Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;

function colorStamp($stamp)
{
    $ost = $stamp % 4;
    $color = ($ost == 0) ? $color = Maya::COLOR_YELLOW : $ost;
    switch ($color) {
        case Maya::COLOR_RED:
            return '#f34035';
            break;
        case Maya::COLOR_WHITE:
            return '#ffffff';
            break;
        case Maya::COLOR_BLUE:
            return '#68b3e2';
            break;
        case Maya::COLOR_YELLOW:
            return '#e9ee62';
            break;
    }
}

?>
<p style="margin-top: 20px;">Цолькин от <u><?= GsssHtml::dateString($days[1][1]['date']) ?></u> до
    <u><?= GsssHtml::dateString($days[20][13]['date']) ?></u></p>
<table border="0" cellspacing="0" cellpading="0" style="margin-right: 10px; margin-bottom: 0px;"
       class="border1px000solid">
    <tbody>
    <?php
    foreach ($days as $row) {
        $day = $row[1];
        ?>
        <tr align="center">
            <td align="center" bgcolor="" height="30" width="40">
                <img
                    class="js-stamp"
                    title="<?= Maya::$stampRows[ $day['stamp'] - 1 ][0] ?>"
                    border="0"
                    alt=""
                    width="23"
                    src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $row[1]['stamp'] ?>.gif">
            </td>
            <?php
            foreach ($row as $day) {
                ?>
                <td align="center"
                    bgcolor="<?= ($day['isPortal']) ? 'green' : (($day['kin'] > 120 and $day['kin'] <= 140) ? '#dcdcdc' : colorStamp($day['stamp'])) ?>"
                    height="30"
                    width="40"
                    <?= ($day['isToday'] == 1) ? "style='border: 3px solid red'" : ''  ?>
                    >

                    <img
                        title="<?= GsssHtml::dateString($day['date']) ?>"
                        class="js-stamp"
                        border="0"
                        alt=""
                        width="23"
                        src="<?= $mayaAssetUrl ?>/images/ton/<?= $day['ton'] ?>.gif"
                        ><br>
                    <?= $day['kin'] ?>

                </td>
            <?php
            }
            ?>
        </tr>
        <tr align="center" class="dates" style="display: none;">
            <td align="center" bgcolor="" height="30" width="40">
            </td>
            <?php
            foreach ($row as $day) {
                ?>
                <td align="center"
                    bgcolor="<?= ($day['isPortal']) ? 'green' : (($day['kin'] > 120 and $day['kin'] <= 140) ? '#dcdcdc' : colorStamp($day['stamp'])) ?>"
                    height="30"
                    width="40"
                    >
                    <span
                        title="<?= GsssHtml::dateString($day['date']) ?>"
                        class="js-stamp"
                        ><?= $day['day'] ?>.<?= $day['month'] ?></span>
                </td>
            <?php
            }
            ?>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<button type="button" class="btn btn-default hidden-print" id="more" style="margin-top: 40px;">Показать еще</button>
