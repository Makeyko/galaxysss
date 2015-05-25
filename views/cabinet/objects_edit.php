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
                <?= $form->field($model, 'name')->label('Название') ?>
                <?= $form->field($model, 'sub_name')->label('Мини описание') ?>

                <?= $form->field($model, 'link')->label('Ссылка') ?>
                <?= $form->field($model, 'description')->label('Кратко')->textarea(['rows' => 10]) ?>
                <?= $form->field($model, 'content')->label('Подробно')->textarea(['rows' => 10]) ?>
                <?= $form->field($model, 'img')->label('Картинка')->widget('cs\Widget\FileUpload2\FileUpload') ?>
                <?= $form->field($model, 'tree_node_id')->label('Раздел')->dropDownList(
                    \yii\helpers\ArrayHelper::merge(
                        ['' => 'Ничего не выбрано'],
                        UnionCategory::getRootList()
                    )
                ) ?>
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
