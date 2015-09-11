<?php
/**
 * @var $items array
 * [
 *     'id'
 *     'class'
 *     'name'
 *     'url'
 * ]
 */
?>

<p>Появились новые послания:</p>
<p><?= \yii\helpers\VarDumper::dumpAsString($items) ?></p>
<p><a href="<?= \yii\helpers\Url::to(['admin_investigator/index'], true) ?>">Добавить в админке</a></p>