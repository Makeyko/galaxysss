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

$this->title = $model->name;
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
                'url'   => ['cabinet/objects_edit', 'id' => $model->union_id],
            ],
            [
                'label' => 'Офисы',
                'url'   => ['cabinet_office/index', 'unionId' => $model->union_id],
            ],
            $model->name,
        ],
    ]) ?>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Успешно обновлено.
        </div>

    <?php else: ?>


        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $model->field($form, 'name') ?>
                <?= $model->field($form, 'point') ?>
                <?= $model->field($form, 'content') ?>

                <hr class="featurette-divider">
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
