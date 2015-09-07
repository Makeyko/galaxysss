<?php
/**
 * @var $union \app\models\Union
 */
?>

Обновлено объединение после модерации: <?= $union->getName() ?>
Ссылка на него: <?= \yii\helpers\Url::to(['cabinet/objects_edit', 'id' => $union->getId()]) ?>