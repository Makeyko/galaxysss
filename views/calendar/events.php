<?php
/** @var array $items */
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;

$this->title = 'События';

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">События</h1>
    </div>

    <?php if (count($items) > 0) { ?>
        <?php foreach ($items as $event) {
            $link = $event['link'] . '';
            if ($link == '') {
                $link = '/events/' . $event['id'];
            }
            ?>
            <div class="col-lg-4">
                <h3><?= $event['name'] ?></h3>

                <p><?= $event['date'] ?></p>

                <p style="margin-bottom: 0px;padding-bottom: 0px;">
                    <a href="<?= $link ?>" target="_blank">
                        <img
                            src="<?= $event['image'] ?>"
                            width="100%"
                            alt=""
                            class="thumbnail"
                            >
                    </a>
                </p>
                <!--                    <table>-->
                <!--                        <tr>-->
                <!--                            <td style='font-family: "courier new", "times new roman", monospace; font-size: 8pt;text-align: center;'>-->
                <!--                                12-->
                <!--                            </td>-->
                <!--                            <td style='font-family: "courier new", "times new roman", monospace; font-size: 8pt;text-align: center;'>-->
                <!--                                13-->
                <!--                            </td>-->
                <!--                            <td style='font-family: "courier new", "times new roman", monospace; font-size: 8pt;text-align: center;'>-->
                <!---->
                <!--                            </td>-->
                <!--                            <td style='font-family: "courier new", "times new roman", monospace; font-size: 8pt;text-align: center;'>-->
                <!--                                23-->
                <!--                            </td>-->
                <!--                            <td style='font-family: "courier new", "times new roman", monospace; font-size: 8pt;text-align: center;'>-->
                <!--                                24-->
                <!--                            </td>-->
                <!--                        </tr>-->
                <!--                        <tr>-->
                <!--                            <td>-->
                <!--                                <img src="/assets/57410080/images/ton/12.gif" width="20">-->
                <!--                            </td>-->
                <!--                            <td>-->
                <!--                                <img src="/assets/57410080/images/ton/12.gif" width="20">-->
                <!--                            </td>-->
                <!--                            <td style="padding-right: 10px;padding-left: 5px;">-->
                <!--                                <img src="/assets/57410080/images/ton/3.gif" width="20">-->
                <!--                            </td>-->
                <!--                            <td>-->
                <!--                                <img src="/assets/57410080/images/ton/12.gif" width="20">-->
                <!--                            </td>-->
                <!--                            <td>-->
                <!---->
                <!--                                <img src="/assets/57410080/images/ton/12.gif" width="20">-->
                <!--                            </td>-->
                <!--                        </tr>-->
                <!--                        <tr>-->
                <!--                            <td style="padding-right: 5px;">-->
                <!--                                <img src="/assets/57410080/images/stamp3/12.gif" width="20">-->
                <!--                            </td>-->
                <!--                            <td style="padding-right: 5px;">-->
                <!--                                <img src="/assets/57410080/images/stamp3/12.gif" width="20">-->
                <!--                            </td>-->
                <!--                            <td>-->
                <!--                            </td>-->
                <!--                            <td style="padding-right: 5px;">-->
                <!--                                <img src="/assets/57410080/images/stamp3/12.gif" width="20">-->
                <!---->
                <!--                            </td>-->
                <!--                            <td>-->
                <!---->
                <!--                                <img src="/assets/57410080/images/stamp3/12.gif" width="20" id="dd1">-->
                <!---->
                <!--                                <div style="position: absolute; top: 508px;left: 136px; z-index: 999; ">-->
                <!--                                    <img src="/assets/57410080/images/stamp3/13.gif" width="10" alt="dddd" onmouseover="" style="border-radius: 5px;">-->
                <!--                                </div>-->
                <!--                            </td>-->
                <!--                        </tr>-->
                <!--                    </table>-->
            </div>
        <?php } ?>
    <?php } ?>



</div>