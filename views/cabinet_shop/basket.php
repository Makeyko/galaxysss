<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <a href="<?= \yii\helpers\Url::to(['cabinet_shop/order']) ?>" class="btn btn-primary">Оформить заказ</a>

    </div>
</div>
