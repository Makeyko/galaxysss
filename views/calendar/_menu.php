<?php

use yii\helpers\Url;

?>
<div class="col-lg-2 hidden-print">
    <div class="list-group">
        <a href="<?= Url::to(['calendar/colkin']) ?>" class="list-group-item<?php if (Url::to(['calendar/colkin']) == Url::to()) { echo ' active'; } ?>"> Цолькин </a>
        <a href="<?= Url::to(['calendar/moon']) ?>" class="list-group-item<?php if (Url::to(['calendar/moon']) == Url::to()) { echo ' active'; } ?>"> Год (по лунам) </a>
        <a href="<?= Url::to(['calendar/friends']) ?>" class="list-group-item<?php if (Url::to(['calendar/friends']) == Url::to()) { echo ' active'; } ?>"> Друзья </a>
        <a href="<?= Url::to(['calendar/orakul']) ?>" class="list-group-item<?php if (Url::to(['calendar/orakul']) == Url::to()) { echo ' active'; } ?>"> Оракул дня </a>
        <a href="<?= Url::to(['calendar/yasnih_znakov']) ?>" class="list-group-item<?php if (Url::to(['calendar/yasnih_znakov']) == Url::to()) { echo ' active'; } ?>"> Ясные знаки </a>
    </div>
</div>