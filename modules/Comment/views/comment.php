<?php

use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var array $item */
/** @var string $time */

/**
 * В шаблоне будут такие подстановки
 *
 * {user_1_id}
 * {user_1_name}
 * {user_1_avatar}
 */

?>

<div class="media">
    <div class="media-left">
        <a href="/user/<?= $item['user_id'] ?>"> <img
                class="media-object"
                src="{user_<?= $item['user_id'] ?>_avatar}"
                alt="{user_<?= $item['user_id'] ?>_name}"
                height="64"
                width="64"
                > </a>
    </div>
    <div class="media-body">

<!--        <choose>-->
<!--            <when test="user.id = 1">-->
<!--                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--            </when>-->
<!--        </choose>-->


        <h4 class="media-heading"><a href="/user/<?= $item['user_id'] ?>">{user_<?= $item['user_id'] ?>_name}</a> <span class="text-muted"
                                                                             style="font-size: 70%;padding-left: 10px;"><?= $time ?></span></h4>

        <p><?= $item['content'] ?></p>
    </div>
</div>