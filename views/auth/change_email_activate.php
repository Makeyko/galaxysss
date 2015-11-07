<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\Form\Registration */

$this->title = 'Смена Email';
?>
<h1 class="page-header"><?= Html::encode($this->title) ?></h1>

<div class="alert alert-success">
    Поздравляем вы успешно установили новый Email.
</div>