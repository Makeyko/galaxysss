<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;
use yii\widgets\Breadcrumbs;

/** @var $this yii\web\View */
/** @var $union       \app\models\Union */
/** @var $shop        \app\models\Shop */
/** @var $breadcrumbs array */
/** @var $category    \app\models\UnionCategory */
/** @var $items       array gs_unions_shop_product.* */

$this->title = 'Магазин';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => $breadcrumbs
        ]) ?>
        <hr>
    </div>

    <div class="col-lg-4">
        <img class="img-thumbnail" src="<?= $union->getImage() ?>">
    </div>
    <div class="col-lg-8">

        <p>Товары</p>

        <?php foreach($items as $item) { ?>
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?= Url::to(['union_shop/product', 'id' => $item['id'], 'union_id' => $union->getId(), 'category' => $category->getField('id_string')]) ?>">
                        <img src="<?= $item['image'] ?>"  width="100%" class="thumbnail">
                    </a>
                </div>
                <div class="col-lg-8">
                    <p><?= $item['description'] ?></p>
                    <hr>
                    <p><?= Yii::$app->formatter->asDecimal($item['price']) ?></p>
                    <button class="btn btn-default btn-lg buttonAdd" style="100%">Добавить</button>
                </div>
            </div>
        <?php } ?>

        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($union->getImage(), true), false),
            'url'         => Url::current([], true),
            'title'       => $union->getName() . '. Магазин',
            'description' => 'ff',
        ]) ?>
    </div>


</div>