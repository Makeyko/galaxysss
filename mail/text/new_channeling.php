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

Появились новые послания:
<?= \yii\helpers\VarDumper::dumpAsString($items) ?>
Добавить в админке: <?= \yii\helpers\Url::to(['admin_investigator/index'], true) ?>