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
/** @var $treeNode    \app\models\Shop\TreeNode */
/** @var $product     \app\models\Shop\Product */

$this->title = $product->getField('name');
$this->params['breadcrumbs'][] = $this->title;


$url = Url::to(['shop/basket']);
$urlAdd = Url::to(['shop/basket_add']);
$this->registerJs(<<<JS
    $('#addToCart').click(function() {
        var id = $(this).data('id');
        ajaxJson({
            url: '{$urlAdd}',
            data: {
                id: id
            },
            success: function(ret) {
                var basket = $('#basketCount');
                var span;
                if (basket.length > 0) {
                    var count = basket.html();
                    basket.html(ret);
                    span = $('#basketCount').popover({
                        content: 'Товар добавлен',
                        placement: 'bottom'
                    });
                    span.popover('show');
                    window.setTimeout(function() {
                        span.popover('hide');
                    }, 2000);
                } else {
                    var userMenu = $('#userBlockLi');
                    span = $('<span>', {
                                id: 'basketCount',
                                class: 'label label-success',
                                title: 'Корзина'
                            }).tooltip({placement:"left"}).html(ret).popover({
                        content: 'Товар добавлен',
                        placement: 'bottom'
                    });
                    var liBasket = $('<li>').append(
                        $('<a>', {
                            href: '{$url}',
                            style: 'padding-right: 0px;  padding-bottom: 0px;'
                        }). append(
                            span
                        )
                    );
                    liBasket.insertBefore(userMenu);
                    span.popover('show');
                    window.setTimeout(function() {
                        span.popover('hide');
                    }, 2000);
                }
            }
        });
    });
JS
);
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
        <img class="img-thumbnail" src="<?= $product->getImage() ?>">
    </div>
    <div class="col-lg-8">

        <p><?= $product->getField('content') ?></p>
        <hr>
        <p>Цена: <?= Yii::$app->formatter->asDecimal($product->getField('price'), 0) ?> руб</p>
        <hr>
        <p><button class="btn btn-default" id="addToCart" data-id="<?= $product->getId() ?>">В корзину</button></p>



        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($product->getImage(), true), false),
            'url'         => Url::current([], true),
            'title'       => $product->getField('name'),
            'description' => 'ff',
        ]) ?>
    </div>


</div>