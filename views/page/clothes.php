<?php
$this->title = 'Одежда';
?>
<div class="container">
    <div class="page-header">
        <h1>Одежда</h1>
    </div>
    <p class="lead">Одежда активирует энергетические центры и подчеркивает божественную красоту тела ангела.</p>

    <p><img src="/images/page/clothes/header2.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(9) ?>
    </div>
</div>