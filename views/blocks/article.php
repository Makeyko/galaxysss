<?php

/** @var $item array article */
/** @var $category string */

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;


?>
<div class="row">
    <div class="thumbnail">
        <a href="<?php
        $item2 = [
            'id'       => $item['id_string'],
            'year'     => substr($item['date_insert'], 0, 4),
            'month'    => substr($item['date_insert'], 5, 2),
            'day'      => substr($item['date_insert'], 8, 2),
            'category' => $category,
        ];
        echo "/category/{$item2['category']}/article/{$item2['year']}/{$item2['month']}/{$item2['day']}/{$item2['id']}" ;
        ?>">
            <img alt="100%x200"
                 src="<?= $item['image'] ?>"
                 style="width: 100%; display: block;">
        </a>

        <div class="caption">
            <h3><?= $item['header'] ?></h3>

            <p><?= $item['description'] ?></p>
        </div>
    </div>
</div>
