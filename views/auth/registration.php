<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\Form\Registration */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="site-contact">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Благодрим вас за регистрацию.
            </div>

        <?php else: ?>

            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin([
                        'id'                   => 'contact-form',
                        'enableAjaxValidation' => true,
                    ]); ?>
                    <?php $field = $form->field($model, 'email',['inputOptions' => ['placeholder' => 'email']])->label('Почта', ['class' => 'hide']);
                    $field->validateOnBlur = true;
                    $field->validateOnChange = true;
                    echo $field;
                    ?>
                    <?= $form->field($model, 'password1', ['inputOptions' => ['placeholder' => 'Пароль']])->passwordInput()->label('Пароль', ['class' => 'hide']) ?>
                    <?= $form->field($model, 'password2', ['inputOptions' => ['placeholder' => 'Повторите пароль еще раз']])->passwordInput()->label('Пароль повтор', ['class' => 'hide']) ?>
                    <?php
                    $field = $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]);
                    $field->enableAjaxValidation = false;
                    echo $field;
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>