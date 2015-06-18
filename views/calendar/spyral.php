<?php
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;
use yii\web\View;

$this->title = 'Спирали';

$this->registerJsFile('/js/pages/calendar/spyral.js', [
    'depends' => [
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

    <div class="page-header">
        <h1><?= $this->title ?></h1>
    </div>

</div>