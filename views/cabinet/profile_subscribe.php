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
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                <div class="alert alert-success">
                    Успешно обновлено.
                </div>

            <?php else: ?>

                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $model->field($form, 'subscribe_is_news')->checkbox() ?>
                <?= $model->field($form, 'subscribe_is_site_update')->checkbox() ?>
                <?= $model->field($form, 'subscribe_is_manual')->checkbox() ?>


                <hr class="featurette-divider">
                <div class="form-group">
                    <?= Html::submitButton('Обновить', ['class' => 'btn btn-default', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <div class="list-group">
                <a href="<?= Url::to(['cabinet/profile']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile']) == Url::to()) { echo ' active'; } ?>"> Профиль </a>
                <a href="<?= Url::to(['cabinet/profile_subscribe']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile_subscribe']) == Url::to()) { echo ' active'; } ?>"> Рассылки </a>
            </div>
        </div>
    </div>


</div>
