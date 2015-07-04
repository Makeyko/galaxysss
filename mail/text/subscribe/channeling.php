<?php
/**
 * @var $item \app\models\Chenneling
 * @var $user \app\models\user
 */

use yii\helpers\Html;
use app\services\GsssHtml;

$content = $item->getField('description');
$content = $content . '';
if ($content == '') {
    $content = GsssHtml::getMiniText($item->getField('content'));
}
?>

<?= $item->getName() ?>

<?= $content ?>

Читать далее: <?= $item->getLink(true) ?>