<?php
/**
 * @var $union \app\models\Union
 */
?>

<p>Добавлено новое объединение: <?= $union->getName() ?></p>
<p><a href="<?= \yii\helpers\Url::to(['cabinet/objects_edit', 'id' => $union->getId()]) ?>">Ссылка на него</a></p>