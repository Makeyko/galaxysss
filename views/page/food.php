<?php

use yii\helpers\Url;

$this->title = 'Питание';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">В здоровом теле здоровый дух.</p>

        <p><img src="/images/page/food/51.jpg" width="100%" class="thumbnail"></p>
    </div>


    <?= \app\services\GsssHtml::unionCategoryItems(4) ?>
    <div class="col-lg-12">
        <h2 class="page-header">Статьи</h2>
    </div>
    <?php foreach ($articleList as $item) {
        echo \app\services\GsssHtml::articleItem($item, 'food');
    } ?>


    <div class="col-lg-12">
    <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/energy/1405027_571610319578558_903459749_o1.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'В каждой точке вселенной находится сверхизбыток энергии, а значит на Земле присутствует
            Богатство Чистейшей Энергии.',
    ]) ?>
</div>
</div>