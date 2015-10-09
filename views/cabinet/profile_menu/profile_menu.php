<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;
use yii\helpers\Url;

/* @var $this yii\web\View */

?>
<div class="list-group">
    <a href="<?= Url::to(['cabinet/profile']) ?>"
       class="list-group-item<?php if (Url::to(['cabinet/profile']) == Url::to()) {
           echo ' active';
       } ?>"> Профиль </a>
    <a href="<?= Url::to(['cabinet/profile_subscribe']) ?>"
       class="list-group-item<?php if (Url::to(['cabinet/profile_subscribe']) == Url::to()) {
           echo ' active';
       } ?>"> Рассылки </a>
    <a href="<?= Url::to(['cabinet/profile_human_design']) ?>"
       class="list-group-item<?php if (Url::to(['cabinet/profile_human_design']) == Url::to()) {
           echo ' active';
       } ?>"> Дизайн Человека </a>
    <a href="<?= Url::to(['cabinet/profile_zvezdnoe']) ?>"
       class="list-group-item<?php if (Url::to(['cabinet/profile_zvezdnoe']) == Url::to()) {
           echo ' active';
       } ?>"> Звездное происхождение </a>
    <a href="<?= Url::to(['cabinet/profile_time']) ?>"
       class="list-group-item<?php if (Url::to(['cabinet/profile_time']) == Url::to()) {
           echo ' active';
       } ?>"> Персональная Галактическая Печать</a>
</div>
