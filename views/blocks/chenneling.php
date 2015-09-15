<?php

/** @var $item \app\models\Blog */

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;


$item2 = [
    'id'       => $item->getField('id_string'),
    'year'     => substr($item['date_insert'], 0, 4),
    'month'    => substr($item['date_insert'], 5, 2),
    'day'      => substr($item['date_insert'], 8, 2),
];

?>
<div class="thumbnail">
    <a href="<?= "/chenneling/{$item2['year']}/{$item2['month']}/{$item2['day']}/{$item2['id']}" ?>">
        <img
            src="<?= $item['img'] ?>"
            style="width: 100%; display: block;">
    </a>

    <div class="caption">
        <h3><?= $item['header'] ?></h3>

        <p><?= $item['description'] ?></p>
    </div>
</div>