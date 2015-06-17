<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Редактирование профиля';
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
                <?= $form->field($model, 'name_first')->label('Имя') ?>
                <?= $form->field($model, 'name_last')->label('Фамилия') ?>
                <?= $form->field($model, 'avatar')->label('Картинка')->widget('cs\Widget\FileUpload2\FileUpload') ?>

                <?php if (isset($model->vk_id)) { ?>
                    <p>Профиль: <?= $model->vk_id ?> </p>
                <?php } else { ?>
                    <p><a href="<?= Url::to(['auth/auth', 'authclient' => 'vkontakte']) ?>" target="_blank">Присоединить
                            профиль</a></p>
                <?php } ?>

                <?php if (isset($model->fb_id)) { ?>
                    <p>Профиль: <?= $model->fb_id ?> </p>
                <?php } else { ?>
                    <p><a href="<?= Url::to(['auth/auth', 'authclient' => 'facebook']) ?>" target="_blank">Присоединить
                            профиль</a></p>
                <?php } ?>


                <div class="form-group">
                    <?= Html::submitButton('Обновить', ['class' => 'btn btn-default', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
</div>
