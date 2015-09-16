<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Редактирование рассылок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

        <div class="col-lg-8">
            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                <div class="alert alert-success">
                    Успешно обновлено.
                </div>

            <?php else: ?>

                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'layout'  => 'horizontal'
                ]); ?>
                <?= $model->field($form, 'subscribe_is_news') ?>
                <?= $model->field($form, 'subscribe_is_site_update') ?>
                <?= $model->field($form, 'subscribe_is_manual') ?>


                <hr class="featurette-divider">
                <div class="form-group">
                    <?= Html::submitButton('Обновить', [
                        'class' => 'btn btn-default',
                        'name'  => 'contact-button',
                        'style' => 'width:100%',

                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>

            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <div class="list-group">
                <a href="<?= Url::to(['cabinet/profile']) ?>"
                   class="list-group-item<?php if (Url::to(['cabinet/profile']) == Url::to()) {
                       echo ' active';
                   } ?>"> Профиль </a>
                <a href="<?= Url::to(['cabinet/profile_subscribe']) ?>"
                   class="list-group-item<?php if (Url::to(['cabinet/profile_subscribe']) == Url::to()) {
                       echo ' active';
                   } ?>"> Рассылки </a>
                <a href="<?= Url::to(['cabinet/profile_human_design']) ?>"
                   class="list-group-item<?php if (Url::to(['cabinet/profile_human_design']) == Url::to()) {
                       echo ' active';
                   } ?>"> Дизайн Человека </a>
            </div>
        </div>
    </div>

</div>
