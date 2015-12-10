<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Магазин';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Успешно обновлено.
        </div>

    <?php else: ?>


        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $model->field($form, 'name') ?>
                <?= $model->field($form, 'dostavka') ?>
                <?= $model->field($form, 'admin_email') ?>

                <?php if ($model->union_id) { ?>
                    <hr>
                    <a href="<?= \yii\helpers\Url::to(['cabinet_shop_shop/product_list', 'id' => $model->union_id]) ?>" class="btn btn-default">Товары</a>
                    <a href="<?= \yii\helpers\Url::to(['cabinet_shop_shop/request_list', 'id' => $model->union_id]) ?>" class="btn btn-default">Заказы</a>
                <?php } ?>
                <hr>
                <div class="form-group">
                    <?= Html::submitButton('Обновить', [
                        'class' => 'btn btn-default',
                        'name'  => 'contact-button',
                        'style' => 'width:100%',
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
</div>
