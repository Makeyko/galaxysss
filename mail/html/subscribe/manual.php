<?php
/**
 * @var $subscribeHistory \app\models\SubscribeHistory
 */

use yii\helpers\Html;
use app\services\GsssHtml;

?>

<h4><?= Html::encode($subscribeHistory->getField('subject')) ?></h4>

<?= $subscribeHistory->getField('content') ?>
