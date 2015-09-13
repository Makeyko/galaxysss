<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $user \app\models\User */

$name = $user->getField('name_first') . $user->getField('name_last') . $user->getField('email');

$this->title = $name;
?>
<div class="container">
    <h1 class="page-header"><?= $user->getField('name_first') . ' ' . $user->getField('name_last') ?> <a href="<?= \yii\helpers\Url::to(['cabinet/profile'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> Редактировать</a></h1>

    <div class="col-lg-4">
        <img src="<?= $user->getAvatar() ?>" class="thumbnail" style="width: 100%;border-radius: 20px;"/>
    </div>
    <div class="col-lg-8">

        <div class="panel panel-default">
            <div class="panel-heading">Дизайн Человека</div>
            <div class="panel-body">
                <img src="/upload/635556384000000000_.png" style="width: 100%;">
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Древо Рода</div>
            <div class="panel-body">
                <img src="/upload/635556384000000000_.png" style="width: 100%;">
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Наука о времени</div>
            <div class="panel-body">
                <img src="/upload/635556384000000000_.png" style="width: 100%;">
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Звездное происхождение</div>
            <div class="panel-body">
                <img src="/upload/635556384000000000_.png" style="width: 100%;">
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Обучение</div>
            <div class="panel-body">
                <img src="/upload/635556384000000000_.png" style="width: 100%;">
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">О себе</div>
            <div class="panel-body">
                <img src="/upload/635556384000000000_.png" style="width: 100%;">
            </div>
        </div>
    </div>

</div>
