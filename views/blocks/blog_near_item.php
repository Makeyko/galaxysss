<?php

/** @var $item \app\models\Blog */

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;


?>
<div class="thumbnail">
    <a href="<?= $item->getLink() ?>">
        <img
            src="<?= $item->getImage() ?>"
            style="width: 100%; display: block;">
    </a>

    <div class="caption">
        <h3><?= $item->getName() ?></h3>

        <p><?= $item->getField('description') ?></p>
    </div>
</div>