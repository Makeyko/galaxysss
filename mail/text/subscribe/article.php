<?php
/**
 * @var $item \app\models\Article
 * @var $user \app\models\user
 */

use yii\helpers\Html;
use app\services\GsssHtml;

$content = $item->getField('description', '');
if ($content == '') {
    $content = GsssHtml::getMiniText($item->getField('content'));
}
?>

На инструмент Вознесения было добавлено следующая статья:
<?= $item->getName() ?>

Краткое содержание:
<?= $content ?>

Читать далее по ссылке:
<?= $item->getLink(true) ?>