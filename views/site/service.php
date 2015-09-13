<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $lineArray array ['x' => array, 'y' => array[[1,2,3,..],...]] Регистрация за один день */
/* @var $lineArray2 array ['x' => array, 'y' => array[[1,2,3,..],...]] Прирост пользователей общий */

$this->title = 'Сервис';
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Удаление кеша FB: <a href="https://developers.facebook.com/tools/debug/" target="_blank">https://developers.facebook.com/tools/debug/</a></p>
    <p>Bootstrap Addons: <a href="http://bootsnipp.com/tags/user-interface" target="_blank">http://bootsnipp.com/tags/user-interface</a></p>
</div>
