<?php

$this->title = 'Идеологические';

?>
<div class="container">
    <div class="page-header">
        <h1>Идеологические</h1>
    </div>
    <p class="lead">Идеологические.</p>

    <p><img src="/images/page/idea/header.jpg" width="100%" class="thumbnail"></p>

    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(14) ?>
    </div>
</div>