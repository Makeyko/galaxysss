<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Звездное происхождение';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?>


        </h1>
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
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $model->field($form, 'data')->textarea(['rows' => 20]) ?>

                <hr>
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
