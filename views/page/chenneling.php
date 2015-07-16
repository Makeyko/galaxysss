<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $html string код html */

$this->title = 'Послания';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/pages/page/chenneling.js', [
    'depends' => [
        'yii\web\JqueryAsset',
    ]
]);

?>

<?= $html ?>