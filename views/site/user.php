<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $user \app\models\User */

$name = $user->getField('name_first') . ' ' . $user->getField('name_last');

$this->title = $name;

?>
<div class="container">
    <h1 class="page-header"><?= $user->getField('name_first') . ' ' . $user->getField('name_last') ?> <a href="<?= \yii\helpers\Url::to(['cabinet/profile'])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> Редактировать</a></h1>

    <div class="col-lg-4">
        <img src="<?= $user->getAvatar() ?>" class="thumbnail" style="width: 100%;border-radius: 20px;"/>
    </div>
    <div class="col-lg-8">

        <?php $humanDesign = $user->getHumanDesign();


        ?>

        <div class="panel panel-default">
            <div class="panel-heading">Дизайн Человека
                <?php if (!\Yii::$app->user->isGuest) {
                    if (!\Yii::$app->user->id == $user->getId()) {
                    $this->registerJs(<<<JS
$('.buttonDelete').click(function(){
    ajaxJson({
            url: '/cabinet/profile/humanDesign/delete',
            success: function(){
                window.location = '/cabinet/profile/humanDesign'
            }
        })
    }
);
JS
                    );

                }}?>
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default btn-xs buttonDelete" >
                        Удалить и пересчитать
                    </button>
                </div>
                <?php if (!\Yii::$app->user->isGuest) {} ?>
            </div>
            <div class="panel-body">
                <img src="<?= $humanDesign->getImage() ?>" style="width: 100%;">
                <table class="table table-striped table-hover" style="width: auto;" align="center">
                    <tr>
                        <td>Тип</td>
                        <td><?= $humanDesign->type->text ?></td>
                    </tr>
                    <tr>
                        <td>Профиль</td>
                        <td><?= $humanDesign->profile->text ?></td>
                    </tr>
                    <tr>
                        <td>definition</td>
                        <td><?= $humanDesign->definition->text ?></td>
                    </tr>
                    <tr>
                        <td>inner</td>
                        <td><?= $humanDesign->inner->text ?></td>
                    </tr>
                    <tr>
                        <td>Стратегия</td>
                        <td><?= $humanDesign->strategy->text ?></td>
                    </tr>
                    <tr>
                        <td>Тема ложного Я</td>
                        <td><?= $humanDesign->theme->text ?></td>
                    </tr>
                    <tr>
                        <td>Крест</td>
                        <td><?= $humanDesign->cross->text ?></td>
                    </tr>
                </table>
            </div>
        </div>

<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">Древо Рода</div>-->
<!--            <div class="panel-body">-->
<!--                <img src="/upload/635556384000000000_.png" style="width: 100%;">-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">Наука о времени</div>-->
<!--            <div class="panel-body">-->
<!--                <img src="/upload/635556384000000000_.png" style="width: 100%;">-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">Звездное происхождение</div>-->
<!--            <div class="panel-body">-->
<!--                <img src="/upload/635556384000000000_.png" style="width: 100%;">-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">Обучение</div>-->
<!--            <div class="panel-body">-->
<!--                <img src="/upload/635556384000000000_.png" style="width: 100%;">-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">О себе</div>-->
<!--            <div class="panel-body">-->
<!--                <img src="/upload/635556384000000000_.png" style="width: 100%;">-->
<!--            </div>-->
<!--        </div>-->
    </div>

</div>
