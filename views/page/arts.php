<?php

$this->title = 'Художники';

?>
<div class="container">
    <div class="page-header">
        <h1>Художники</h1>
    </div>
    <p class="lead">Художники рисуют миры в которых мы живем.</p>

    <p><img src="/images/page/arts/header.png" width="100%" class="thumbnail"></p>

    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(12) ?>
    </div>
</div>