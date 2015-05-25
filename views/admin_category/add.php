<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Добавить категорию';
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
                    'id' => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $form->field($model, 'header')->label('Название') ?>
                <?= $form->field($model, 'description')->label('Описание')->hint('код HTML')->textarea(['rows' => 10]) ?>
                <?= $form->field($model, 'image')->label('Картинка')->widget('cs\Widget\FileUpload2\FileUpload') ?>
                <?= $form->field($model, 'parent_id')->label('Родительский')->radioList(
                    ArrayHelper::map(\app\models\Category::query()->all(),'id', 'header')
                ) ?>

                <hr class="featurette-divider">
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
