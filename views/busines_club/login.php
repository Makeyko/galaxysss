
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Вход в измерение личного счастья';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #passwordrecover-email {

    }
</style>
<div class="container">

    <div class="site-login">
        <div class="col-lg-6 col-lg-offset-3">
            <h2 class="page-header text-center" style="margin-top: 0px;"><img src="/images/busines_club/img.png" width="150"><br>Элитный Клуб Фрактального Бизнеса «Vasudev Bagavan»</h2>

            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <p>Пожалуйста заполните нижеследующие поля:</p>

                    <?php $form = ActiveForm::begin([
                        'id'                   => 'login-form',
                        'enableAjaxValidation' => true,
                    ]); ?>

                    <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => 'email']])->label('email', ['class' => 'hide']) ?>
                    <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' => 'Пароль']])->label('Пароль', ['class' => 'hide'])->passwordInput() ?>
                    <?= $model->field($form, 'rememberMe')->label('Запомнить меня') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Войти', [
                            'class' => 'btn btn-primary btn-lg',
                            'name'  => 'login-button',
                            'style' => 'width:100%;',
                        ]) ?>
                    </div>
                    <hr>
                    <p><a style="width: 100%;" class="btn btn-default btn-xs" href="<?= \yii\helpers\Url::to(['auth/password_recover']) ?>" >Восстановить пароль</a>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>


    </div>

</div>