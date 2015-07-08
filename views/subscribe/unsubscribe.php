<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */

$this->title = 'Отписаться от рассылки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-success">
            Вы удачно отписались от рассылки.
        </div>
    </div>

</div>
