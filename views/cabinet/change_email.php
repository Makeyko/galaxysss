<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\Form\Registration */

$this->title = 'Смена логина / почты';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>


<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

    <div class="alert alert-success">
        Поздравляем выполнили первый шаг. Теперь вам необходимо зайти на ваш почтовый ящик который вы только что указали
        и подтвердить свой адрес таким образом. До этого будет действовать еще старый логин/email.
    </div>

<?php else: ?>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id'                   => 'contact-form',
                'enableAjaxValidation' => true,
            ]); ?>
            <?= $form->field($model, 'email')->label('Новый логин / Email') ?>
            <?= $form->field($model, 'password')->label('Пароль от вашего кабинета')->passwordInput() ?>

            <hr>
            <div class="form-group">
                <?= Html::submitButton('Подтвердить', [
                    'class' => 'btn btn-primary',
                    'name'  => 'contact-button',
                    'style' => 'width: 100%',
                ]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php endif; ?>