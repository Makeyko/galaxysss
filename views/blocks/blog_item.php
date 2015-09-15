<?php

/** @var $item \app\models\Blog */

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;

$date = $item->getField('date');
$year = substr($date, 0, 4);
$month = substr($date, 5, 2);
$day = substr($date, 8, 2);

?>

<div class="col-lg-4 blogItem">
    <div class="header">
        <h4><?= Html::encode($item->getName()) ?></h4>
    </div>
    <p style="font-size: 70%; color: #808080;"><?= \app\services\GsssHtml::dateString($date) ?></p>
    <p style="margin-bottom: 0px;padding-bottom: 0px;">
        <a href="<?= $item->getLink() ?>">
            <img src="<?= $item->getImage() ?>" width="100%" alt="" class="thumbnail">
        </a>
    </p>
    <p><?= Html::encode($item->getField('description')) ?></p>
</div>