<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Добавить событие';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Успешно добавлено.
        </div>

    <?php else: ?>


        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $model->field($form, 'name') ?>
                <?= $model->field($form, 'start_date') ?>
                <?= $model->field($form, 'start_time') ?>
                <?= $model->field($form, 'end_date') ?>
                <?= $model->field($form, 'end_time') ?>
                <?= $model->field($form, 'content') ?>
                <?= $model->field($form, 'image') ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить', [
                        'class' => 'btn btn-default',
                        'name'  => 'contact-button'
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
</div>
