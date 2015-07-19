<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = $model->header;
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
                <?= $form->field($model, 'header')->label('Название') ?>
                <?= $model->field($form, 'source') ?>
                <?= $form->field($model, 'description')->label('Кратко')->textarea(['rows' => 20]) ?>
                <?= $form->field($model, 'content')->label('Полно')->widget('cs\Widget\HtmlContent\HtmlContent') ?>
                <?= $form->field($model, 'image')->label('Картинка')->widget('cs\Widget\FileUpload2\FileUpload') ?>
                <?= $form->field($model, 'tree_node_id_mask')->label('Категории')->widget('cs\Widget\CheckBoxTreeMask\CheckBoxTreeMask', [
                    'tableName' => 'gs_unions_tree',
                    'select'    => 'id, header as name',
                ]) ?>

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
