<?php

use yii\helpers\Html;
use app\modules\Comment\Cache as CommentCache;
use yii\bootstrap\ActiveForm;


/** @var $rows */
/**
 * @var int $countPrevision
 * Количество предыдущих комментариев
 */
/** @var $type_id */
/** @var $row_id */

/**
 * В шаблоне будут такие подстановки
 *
 * {user_1_id}
 * {user_1_name}
 * {user_1_avatar}
 */

?>
<div class="page-header">
    <p><b>Комментарии</b></p>
</div>
<div class="media-list commentList">
    <?php if ($countPrevision > 0) { ?>
        <?= Html::button('Предыдущие комментарии ('.$countPrevision.')', [
            'class' => 'btn btn-default',
            'style' => 'width: 100%;',
            'id'    => 'commentMoreButton',
        ]) ?>
    <?php } ?>

    <?php foreach ($rows as $item) { ?>
        <?= $this->render('comment', [
            'item' => $item,
            'time' => Yii::$app->formatter->asDatetime($item['date_insert']),
        ]) ?>
    <?php } ?>
</div>

<div id="commentTemplate" class="hide">
    <?= $this->render('comment', [
        'item' => [
            'id'      => 1,
            'content' => '{content}',
            'user_id' => Yii::$app->user->getId(),
            'time'    => 'Только что',
        ]
    ]); ?>
</div>

<div class="page-header">
    <p><b>Комментировать</b></p>
</div>

