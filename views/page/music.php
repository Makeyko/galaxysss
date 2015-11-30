<?php

use yii\helpers\Url;

$this->title = 'Музыка';

?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= \cs\helpers\Html::encode($this->title) ?></h1>

        <p class="lead">Музыка высших сфер раскрывает сердца и расширяет сознание</p>
        <p>
            <a href="/category/music/407">
                <img src="/images/page/music/sutra.jpg" width="100%" class="thumbnail">
            </a>
        </p>
        <a href="/category/music/407" class="btn btn-success btn-lg" style="width: 100%; margin-bottom: 80px;">
            Слушать и наслаждаться
        </a>
        <hr>

    </div>

    <?= \app\services\GsssHtml::unionCategoryItems(13) ?>

    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'music');
        } ?>
    <?php } ?>


    <div class="col-lg-12">
        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => Url::to('/images/page/money/laxmi.jpg', true),
            'url'         => Url::current([], true),
            'title'       => $this->title,
            'description' => 'Музыка высших сфер раскрывает сердца и расширяет сознание',
        ]) ?>

    </div>
</div>
