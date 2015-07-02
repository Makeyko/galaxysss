<?php

/** @var array $articleList */

$this->title = 'Язык';

?>

<div class="container">

    <div class="page-header">
        <h1>Язык</h1>
    </div>

    <p class="lead">Язык определяет наши архетипы сознания, а значит слова это матрицы программирующие нашу реальность.</p>

    <p><img src="/images/page/language/LNL0D495Xko.jpg" width="100%" class="thumbnail"></p>


    <div class="row featurette">
        <?php
        foreach(\app\models\UnionCategory::getRows(1) as $item) {
            echo \app\services\GsssHtml::unityCategoryItem($item);
        }
        ?>
        <?= \app\services\GsssHtml::unionCategoryItems(1) ?>
    </div>


    <div class="page-header">
        <h2>Статьи</h2>
    </div>
    <div class="row featurette">
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'language');
        } ?>
    </div>

</div>