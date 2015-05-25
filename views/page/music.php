<?php

$this->title = 'Музыка';

?>
<div class="container">
    <div class="page-header">
        <h1>Музыка</h1>
    </div>
    <p class="lead">Музыка высших сфер раскрывает сердца и расширяет сознание</p>

    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(13) ?>
    </div>
</div>
