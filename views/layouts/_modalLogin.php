<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\App\Asset;

?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Вход в измерение личного счастья</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="basic-addon1">@</span>
                        <input type="text" class="form-control" placeholder="Почта"
                               aria-describedby="basic-addon1" id="field-email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-lg  ">
                        <input type="password" class="form-control" placeholder="Пароль" id="field-password">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" id="buttonLogin" style="width: 100px;">
                                    Войти
                                </button>
                            </span>
                    </div>
                    <div class="hide" id="loginFormLoading">
                        <img style="padding-left: 10px;padding-right: 10px;"
                             src="<?= \Yii::$app->assetManager->getBundle(Asset::className())->baseUrl ?>/images/ajax-loader.gif"
                             id="">
                    </div>
                    <p class="text-danger" style="margin-top: 10px;display: none;" id="loginFormError">Здесь выводятся ошибки</p>
                </div>
            </div>
            <div class="modal-footer">
                <p style="text-align: left;"><a href="<?= Url::to(['auth/password_recover']) ?>">Восстановить пароль</a></p>
                <p style="text-align: left;"><a href="<?= Url::to(['auth/registration']) ?>">Регистрация</a></p>
                <?= \yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['auth/auth']
                ]); ?>
            </div>
        </div>
    </div>
</div>