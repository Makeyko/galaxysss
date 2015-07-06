<?php
/** @var $this yii\web\View */
/** @var \app\models\Event $item
 */

use cs\models\Calendar\Maya;
use app\services\GsssHtml;
use yii\helpers\Url;

$this->title = $item->getField('name');

?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>

    <div class="col-lg-12">
        <div class="col-lg-4 col-lg-offset-4">
            <p class="text-center">
                <img class="thumbnail" src="<?= $item->getField('image') ?>" width="100%" alt="">
            </p>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-10 col-lg-offset-1">
            <?= $item->getField('content') ?>
        </div>
    </div>

</div>
