<?php

/** @var array $articleList */

$this->title = 'Язык';

?>

<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Язык</h1>
        <p class="lead">Язык определяет наши архетипы сознания, а значит слова это матрицы программирующие нашу реальность.</p>
        <p><img src="/images/page/language/LNL0D495Xko.jpg" width="100%" class="thumbnail"></p>
    </div>

    <div style="display: table">
        <?php
        foreach(\app\models\UnionCategory::getRows(1) as $item) {
            echo \app\services\GsssHtml::unityCategoryItem($item);
        }
        ?>
        <?= \app\services\GsssHtml::unionCategoryItems(1) ?>
    </div>

    <div class="col-lg-12">
        <h2 class="page-header">Статьи</h2>
    </div>

    <div style="display: table">
    <?php
    foreach ($articleList as $item) {
        echo \app\services\GsssHtml::articleItem($item, 'language');
    }
    ?>
    </div>

</div>