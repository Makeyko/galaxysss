<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

/** @var array $list gs_site_update */
/** @var \yii\web\View $this  */

?>
<?php foreach ($list as $item) { ?>
    <a href="<?= $item['link'] ?>" class="list-group-item">
        <h4><?= $item['name'] ?></h4>
        <div class="row">
            <div class="col-lg-3">
                <?php if ($item['image'] . '' != '') { ?>
                    <img src="<?= $item['image'] ?>" class="thumbnail" width="80">
                <?php } ?>
            </div>

            <div class="col-lg-9">
                <p><?= Html::tag('span', GsssHtml::dateString(date('Y.m.d', $item['date_insert'])), ['style' => 'font-size: 80%; margin-bottom:10px; color: #c0c0c0;']) ?></p>
                <span class="btn btn-default btn-xs"><?= \app\models\SiteUpdateItem::$names[$item['type']] ?></span>
            </div>
        </div>
    </a>
<?php  } ?>