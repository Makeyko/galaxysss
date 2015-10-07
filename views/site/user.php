<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $user \app\models\User */

$name = $user->getField('name_first') . ' ' . $user->getField('name_last');

$this->title = $name;
function getName($point)
{
    if (isset($point[2])) {
        $user = $point[2];
        $arr = [];
        $index = 'name_first';
        if (ArrayHelper::getValue($user, $index, '') != '') {
            $arr[] = $user[ $index ];
        }
        $index = 'name_middle';
        if (ArrayHelper::getValue($user, $index, '') != '') {
            $arr[] = $user[ $index ];
        }
        $index = 'name_last';
        if (ArrayHelper::getValue($user, $index, '') != '') {
            $arr[] = $user[ $index ];
        }
        if (ArrayHelper::getValue($user, 'date_born', '') != '') {
            if (ArrayHelper::getValue($user, 'date_death', '') != '') {
                $start = Yii::$app->formatter->asDate(ArrayHelper::getValue($user, 'date_born', ''));
                $end = Yii::$app->formatter->asDate(ArrayHelper::getValue($user, 'date_death', ''));
                $arr[] = "({$start} - {$end})";
            } else {
                $start = Yii::$app->formatter->asDate(ArrayHelper::getValue($user, 'date_born', ''));
                $arr[] = "({$start})";
            }
        }

        return join(' ', $arr);
    } else {
        return '';
    }
}

?>
<div class="container">
<h1 class="page-header">Паспорт гражданина Галактики</h1>

<h2 class="page-header"><?= $user->getField('name_first') . ' ' . $user->getField('name_last') ?>

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

</h2>

<div class="row">
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
                                <button type="button" class="btn btn-default btn-xs buttonDelete"
                                ">
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
                            <a class="btn btn-default"
                               href="<?= \yii\helpers\Url::to(['cabinet/profile_human_design']) ?>">
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

        <div class="panel panel-default">
            <div class="panel-heading">Древо Рода</div>
            <div class="panel-body">
                <img src="/images/passport/tree.png" usemap="#Map"/>
                <?php
                $points = [
                    1 => [128, 35],
                    2 => [128 + 256, 35],
                ];
                for ($i = 0; $i < 4; $i++) {
                    $points[] = [64 + (128 * $i), 61];
                }
                for ($i = 0; $i < 8; $i++) {
                    $points[] = [32 + (64 * $i), 79];
                }
                for ($i = 0; $i < 16; $i++) {
                    $points[] = [16 + (32 * $i), 88];
                }
                for ($i = 0; $i < 32; $i++) {
                    $points[] = [8 + (16 * $i), 97];
                }
                for ($i = 0; $i < 64; $i++) {
                    $points[] = [4 + (8 * $i), 105];
                }

                $rod = \app\models\UserRod::query(['user_id' => $user->getId()])->all();
                foreach ($rod as $i) {
                    $points[ $i['rod_id'] ][] = $i;
                }
                ?>
                <map name="Map">
                    <?php foreach ($points as $key => $point) { ?>
                        <area
                            class="rectTitle"
                            shape="rect"
                            title="<?= getName($points[ $key ]) ?>"
                            coords="<?= $point[0] - 2 ?>,<?= $point[1] - 2 ?>,<?= $point[0] + 2 ?>,<?= $point[1] + 2 ?>"
                            href="<?= \yii\helpers\Url::to(['site/user_rod_edit', 'rod_id' => $key, 'user_id' => $user->getId()]) ?>"
                            />
                    <?php } ?>
                </map>
            </div>
        </div>
        <!---->
        <!--        <div class="panel panel-default">-->
        <!--            <div class="panel-heading">Наука о времени</div>-->
        <!--            <div class="panel-body">-->
        <!--                <img src="/upload/635556384000000000_.png" style="width: 100%;">-->
        <!--            </div>-->
        <!--        </div>-->
        <!---->
        <div class="panel panel-default">
            <div class="panel-heading">Звездное происхождение
                <?php if ($user->hasZvezdnoe()) { ?>
                    <div class="btn-group pull-right">
                        <a
                            type="button"
                            class="btn btn-default btn-xs buttonDelete"
                            href="<?= \yii\helpers\Url::to(['cabinet/profile_zvezdnoe']) ?>"
                        ">
                        редактировать
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="panel-body">
                <?php if ($user->hasZvezdnoe()) { ?>
                    <?php $z = $user->getZvezdnoe(); ?>
                    <?= nl2br(Html::encode($z->data)) ?>
                <?php } else { ?>
                    <a href="<?= \yii\helpers\Url::to(['cabinet/profile_zvezdnoe']) ?>" class="btn btn-primary">Заполнить</a>
                <?php } ?>
            </div>
        </div>
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

</div>
