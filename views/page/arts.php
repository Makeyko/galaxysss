<?php

use yii\helpers\Html;
use yii\helpers\Url;
use cs\services\Str;

$this->title = 'Художники';

?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>

        <p class="lead">Художники рисуют миры в которых мы живем.</p>

        <p><img src="/images/page/arts/header.png" width="100%" class="thumbnail"></p>
    </div>

    <?= \app\services\GsssHtml::unionCategoryItems(12) ?>

    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
            <?php foreach ($articleList as $item) {
                echo \app\services\GsssHtml::articleItem($item, 'arts');
            } ?>
        </div>
    <?php } ?>

    <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/arts/header.png', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'Художники рисуют миры в которых мы живем.',
    ]) ?>

</div>


