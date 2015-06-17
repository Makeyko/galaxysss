<?php
$this->title = 'Обучение';
?>
<div class="container">

    <div class="page-header">
        <h1>Процесс обучения</h1>
    </div>
    <p class="lead">Новейшие космологические представления о Вселенной и человеке</p>

    <p><img src="/images/page/study/8879600072.jpg" width="100%" class="thumbnail"></p>

    <div class="row">
        <?= \app\services\GsssHtml::unionCategoryItems(11) ?>
    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'study');
                } ?>
            </div>
        </div>
    <?php } ?>

</div>