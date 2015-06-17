<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $list array gs_services.* */

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
<style>
    .serviceItem {
        height: 700px;
    }
    .serviceItem .header {
        height: 100px;
        vertical-align: bottom;
    }
</style>
    <div class="site-about">
        <div class="page-header">
            <h1><?= $this->title ?></h1>
        </div>

        <?php
        foreach($list as $item) {
            echo \app\services\GsssHtml::serviceItem($item);
        }
        ?>

    </div>
</div>