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
        <?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => [
                $this->title
            ],
            'home'  => [
                'name' => 'я',
                'url'  => \yii\helpers\Url::to(['site/user', 'id' => Yii::$app->user->id])
            ]
        ]) ?>
        <hr>

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
                <?= $model->field($form, 'subscribe_is_tesla') ?>
                <?= $model->field($form, 'subscribe_is_rod') ?>


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
            <?= $this->render('profile_menu/profile_menu') ?>

        </div>
    </div>

</div>
