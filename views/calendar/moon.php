<?php
/** @var array $days */
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;

$this->title = 'Календарь';

$this->registerJsFile('/js/pages/calendar/moon.js', [
        'depends' => [
            'app\assets\LayoutMenu\Asset',
            'app\assets\Maya\Asset',
            'app\assets\ScrollTo',
            'yii\web\JqueryAsset',
            'app\assets\Encoder\Asset',
        ]
    ]);
$mayaAssetUrl = \Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
$pathLayoutMenu = \Yii::$app->assetManager->getBundle('app\assets\LayoutMenu\Asset')->baseUrl;
$this->registerJs("$('.js-stamp').tooltip();");
$this->registerJs("Moon.init('{$mayaAssetUrl}');");
$this->registerJs("var pathLayoutMenu = '{$pathLayoutMenu}';", \yii\web\View::POS_HEAD);

$dayInWeek = date('N') + 1;
if ($dayInWeek == 1) {
    $day = 0;
}
else {
    $day = 7 - ($dayInWeek - 1);
}

$dayWeekList = [
    1 => 'сб',
    2 => 'вс',
    3 => 'пн',
    4 => 'вт',
    5 => 'ср',
    6 => 'чт',
    7 => 'пт',
];

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

        .calendar {
            margin-bottom: 40px;
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

        #main-content {
            margin-bottom: 80px;
        }
    </style>

    <div class="row">
        <div id="lastDay" class="hide"></div>
        <div class="col-lg-10" id="main-content">

            <p><img src="" id="ajax-loader"></p>

            <table class="calendar">

            </table>

            <button class="btn btn-default" id="buttonNextYear">Следующий год</button>

            <hr>
            <?= $this->render('../blocks/share', [
                'image'       => \yii\helpers\Url::to(Yii::$app->getAssetManager()->getBundle('app\assets\Maya\Asset')->get('/images/stamp2/9.jpg') , true),
                'url'         => \yii\helpers\Url::current([], true),
                'title'       => $this->title,
                'description' => $this->title,
            ]) ?>

        </div>
        <?= $this->render('_menu') ?>
    </div>



    <!-- dialog itself, mfp-hide class is required to make dialog hidden -->
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
        <h1>Dialog example</h1>
        <p>This is dummy copy. It is not meant to be read. It has been placed here solely to demonstrate the look and feel of finished, typeset text. Only for show. He who searches for meaning here will be sorely disappointed.</p>
    </div>
</div>