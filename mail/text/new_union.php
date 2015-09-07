<?php
/**
 * @var $union \app\models\Union
 */
?>

Добавлено новое объединение: <?= $union->getName() ?>
Ссылка на него: <?= \yii\helpers\Url::to(['cabinet/objects_edit', 'id' => $union->getId()]) ?>