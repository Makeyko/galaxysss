<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */
/* @var $breadcrumbs array */

$this->title = 'Древо рода';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div>
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        <?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => $breadcrumbs,
            'home'  => [
                'name' => 'я',
                'url'  => \yii\helpers\Url::to(['site/user', 'id' => $model->user_id])
            ]
        ]) ?>
        <hr>
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
                <?= $model->field($form, 'image') ?>
                <?= $model->field($form, 'name_first') ?>
                <?= $model->field($form, 'name_last') ?>
                <?= $model->field($form, 'name_middle') ?>
                <?= $model->field($form, 'description')->textarea(['rows' => 5]) ?>
                <?= $model->field($form, 'content') ?>
                <?= $model->field($form, 'date_born') ?>
                <?= $model->field($form, 'date_death') ?>

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
