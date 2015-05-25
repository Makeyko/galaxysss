<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $items array gs_chaneling_list.* */

$this->title = 'Послания';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <style>
        .chennelingItem {
            height: 650px;
            border-bottom: 1px solid #eee;
        }
        .chennelingItem .header {
            height: 70px;
            vertical-align: bottom;
        }
    </style>
    <div class="site-about">
        <div class="page-header">
            <h1>Послания</h1>
        </div>

        <?php
        foreach($items as $item) {
            echo \app\services\GsssHtml::chennelingItem($item);
        }
        ?>

    </div>
</div>