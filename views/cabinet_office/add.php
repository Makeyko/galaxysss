<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Добавить категорию';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => 'Объединения',
                'url'   => ['cabinet/objects'],
            ],
            [
                'label' => 'Объединение',
                'url'   => [
                    'cabinet/objects_edit',
                    'id' => $model->union_id
                ],
            ],
            [
                'label' => 'Офисы',
                'url'   => [
                    'cabinet_office/index',
                    'unionId' => $model->union_id
                ],
            ],
        ],
    ]) ?>

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
                <?= $form->field($model, 'name')->label('Название') ?>
                <?= $form->field($model, 'point')->label('Местоположение')->widget('cs\Widget\PlaceMap\PlaceMap') ?>
                <?= $model->field($form, 'content') ?>

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
