<?php

use yii\helpers\Url;

$this->title = 'Магазин';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
    </div>


    <div class="col-lg-12">
        <input type="text" class="form-control" size="20"/>
    </div>

    <?php
    $shopList = \app\models\Shop\Product::query()
        ->groupBy('gs_unions_shop.id')
        ->innerJoin('gs_unions_shop_tree', 'gs_unions_shop_tree.id = gs_unions_shop_product.tree_node_id')
        ->innerJoin('gs_unions_shop', 'gs_unions_shop.id = gs_unions_shop_tree.shop_id')
        ->select([
            'gs_unions_shop.*'
        ])
        ->all();
    ?>
    <?php foreach($shopList as $i) { ?>
        <p><?= $shopList['name'] ?></p>
    <?php } ?>

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