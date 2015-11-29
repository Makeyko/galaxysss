<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $items array */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>



        <?php
        $ids = [];
        foreach(\app\modules\Shop\services\Basket::get() as $item) {
            $ids[] = $item['id'];
        }
        $unionRows = \app\models\Shop\Product::query(['in', 'gs_unions_shop_product.id', $ids])
        ->innerJoin('gs_unions', 'gs_unions.id = gs_unions_shop_product.union_id')
        ->select([
            'gs_unions.*'
        ])
            ->groupBy([
                'gs_unions_shop_product.union_id'
            ])
        ->all();

        for ($i = 0; $i < count($unionRows); $i++) {
            $unionRows[$i]['productList'] = \app\models\Shop\Product::query(['union_id' => $unionRows[$i]['id']])
                ->andWhere(['in', 'gs_unions_shop_product.id', $ids])
                ->all();
            for($j=0;$j<count($unionRows[$i]['productList']);$j++) {
                foreach (\app\modules\Shop\services\Basket::get() as $d) {
                    if ($unionRows[$i]['productList'][$j]['id'] == $d['id']) {
                        $unionRows[$i]['productList'][$j]['count'] = $d['count'];
                        continue;
                    }
                }
            }
        }
        ?>

        <table class="table table-striped table-hover">
            <tr>
                <th>
                    #
                </th>
                <th>
                    Наимениование
                </th>
                <th>
                    Кол-во
                </th>
                <th>
                    Стоимость единицы
                </th>
                <th>
                    Стоимость
                </th>
            </tr>
            <?php $c = 1; ?>
            <?php foreach($unionRows as $union) { ?>
            <tr>
                <td>

                </td>
                <td colspan="4">
                    <?= $union['name'] ?>
                </td>
            </tr>
                <?php foreach($union['productList'] as $product) { ?>
                    <tr>
                        <td>
                            <?= $c++; ?>
                        </td>
                        <td>
                            <?= $product['name'] ?>
                        </td>
                        <td>
                            <?= $product['count'] ?>
                        </td>
                        <td>
                            <?= Yii::$app->formatter->asDecimal($product['price'],0) ?>
                        </td>
                        <td>
                            <?= Yii::$app->formatter->asDecimal($product['count'] * $product['price'],0) ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        <a href="<?= \yii\helpers\Url::to(['cabinet_shop/order']) ?>" class="btn btn-primary">Оформить заказ</a>

    </div>
</div>
