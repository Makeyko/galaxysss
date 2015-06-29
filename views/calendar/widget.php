<?php
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;

$this->title = 'Виджеты для календаря Майя';

$this->registerJsFile('/js/pages/calendar/widget.js', [
    'depends' => [
        'app\assets\LayoutMenu\Asset',
        'app\assets\Maya\Asset',
        'cs\assets\ZClip\Asset',
    ]
]);
$this->registerJs("var pathZClip = '".\Yii::$app->assetManager->getBundle('cs\assets\ZClip\Asset')->baseUrl."';", \yii\web\View::POS_HEAD);

$mayaAssetUrl = \Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;

?>
<div class="container">

    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-1">
            1.
        </div>
        <div class="col-lg-3">
            <script src='/js/widget/maya-today.js'></script>
        </div>
        <div class="col-lg-8">
            <textarea rows="5"
                      style="width: 100%;"
                      id="textCode1"
                ><?= Html::encode("<script src='//" . $_SERVER['SERVER_NAME'] . "/js/widget/maya-today.js'></script>") ?></textarea>
            <button class="btn btn-default btn-sm buttonCopy1" id="copy1">Копировать в буфер</button>
        </div>
    </div>

</div>