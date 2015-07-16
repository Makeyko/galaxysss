<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $list array gs_chaneling_list.* */

foreach ($list as $item) {
    echo \app\services\GsssHtml::chennelingItem($item);
}
