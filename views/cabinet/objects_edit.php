<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\Form\Union */

$this->title = $model->name;
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
                    'id' => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $model->field($form, 'name') ?>
                <?= $model->field($form, 'sub_name') ?>
                <?= $model->field($form, 'link') ?>
                <?= $model->field($form, 'description')->textarea(['rows' => 10]) ?>
                <?= $model->field($form, 'content') ?>
                <?= $model->field($form, 'img') ?>
                <?= $model->field($form, 'tree_node_id') ?>

                <hr class="featurette-divider">
                <a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                   aria-controls="collapseExample"> Ссылки на соцсети<span class="caret"
                                                                           style="margin-left: 10px;"></span> </a>

                <div class="collapse" id="collapseExample" style="margin-top: 20px;">
                    <?= $form->field($model, 'group_link_facebook')->label('Ссылка на facebook') ?>
                    <?= $form->field($model, 'group_link_vkontakte')->label('Ссылка на vkontakte') ?>
                    <?= $form->field($model, 'group_link_youtube')->label('Ссылка на youtube') ?>
                    <?= $form->field($model, 'group_link_google')->label('Ссылка на google') ?>
                </div>
                <hr class="featurette-divider">
                <?= Html::a('Офисы',['cabinet_office/index', 'unionId' => $model->id], ['class' => 'btn btn-default']) ?>
                <hr class="featurette-divider">
                <div class="form-group">
                    <?= Html::submitButton('Обновить', ['class' => 'btn btn-default', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
</div>
