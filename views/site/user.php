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
    <h1 class="page-header"><?= $user->getField('name_first') . ' ' . $user->getField('name_last') ?>

        <?php
        if (!\Yii::$app->user->isGuest) {
            if (\Yii::$app->user->id == $user->getId()) {
                ?>

                <a href="<?= \yii\helpers\Url::to(['cabinet/profile']) ?>" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-edit"></span> Редактировать</a>

            <?php
            }
        }
        ?>

    </h1>

    <div class="col-lg-4">
        <img src="<?= $user->getAvatar() ?>" class="thumbnail" style="width: 100%;border-radius: 20px;"/>
    </div>
    <div class="col-lg-8">

        <?php $humanDesign = $user->getHumanDesign(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">Дизайн Человека
                <?php if ($humanDesign) { ?>
                    <?php if (!\Yii::$app->user->isGuest) { ?>
                        <?php if (\Yii::$app->user->id == $user->getId()) {
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
                            ?>
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs buttonDelete"">
                                    Удалить и пересчитать
                                </button>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="panel-body">
                <?php if ($humanDesign) { ?>
                    <img src="<?= $humanDesign->getImage() ?>" style="width: 100%;">
                    <table class="table table-striped table-hover" style="width: auto;" align="center">
                        <tr>
                            <td>Тип</td>
                            <td>
                                <a href="<?= \app\modules\HumanDesign\calculate\YourHumanDesignRu::$links['type'][ $humanDesign->type->href ] ?>">
                                    <?= $humanDesign->type->text ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Профиль</td>
                            <td><?= $humanDesign->profile->text ?></td>
                        </tr>
                        <tr>
                            <td>Определение</td>
                            <td><?= $humanDesign->definition->text ?></td>
                        </tr>
                        <tr>
                            <td>Внутренний Авторитет</td>
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
                            <td>Инкарнационный крест</td>
                            <td><?= $humanDesign->cross->text ?></td>
                        </tr>
                    </table>
                <?php } else { ?>
                    <?php if (!\Yii::$app->user->isGuest) { ?>
                        <?php if (\Yii::$app->user->id == $user->getId()) { ?>
                            <a class="btn btn-default" href="<?= \yii\helpers\Url::to(['cabinet/profile_human_design']) ?>>
                                Посчитать
                            </a>
                        <?php } else { ?>
                            <span class="alert alert-success">Нет</span>
                        <?php } ?>
                    <?php } else { ?>
                        <span class="alert alert-success">Нет</span>
                    <?php } ?>
                <?php } ?>
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
