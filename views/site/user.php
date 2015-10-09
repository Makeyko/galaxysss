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

<div class="panel panel-default">
    <?php $birthDate = $user->getField('birth_date'); ?>
    <?php if ($birthDate) { ?>
        <?php
        $mayaAssetUrl = Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
        $maya = \cs\models\Calendar\Maya::calc($birthDate);
        $analog = 19 - (($maya['stamp'] == 20) ? 0 : $maya['stamp']);
        $analog = ($analog == 0) ? 20 : $analog;
        $antipod = (($maya['stamp'] == 20) ? 0 : $maya['stamp']);
        $antipod = (int)($antipod) + (int)((($antipod > 10) ? -1 : 1) * 10);
        // Ведущий учитель
        {
            $vedun = 0;

            switch ($maya['ton'] % 5) {
                case 0:
                    // + 8 печатей
                    $vedun = $maya['stamp'] + 8;
                    if ($vedun > 20) {
                        $vedun = $vedun - 20;
                    }
                    break;
                case 1:
                    // та же печать
                    $vedun = $maya['stamp'];
                    break;
                case 2:
                    // - 8 печатей
                    $vedun = $maya['stamp'] - 8;
                    if ($vedun <= 0) {
                        $vedun = 20 + $vedun;
                    }
                    break;
                case 3:
                    // + 4 печати
                    $vedun = $maya['stamp'] + 4;
                    if ($vedun > 20) {
                        $vedun = $vedun - 20;
                    }
                    break;
                case 4:
                    // - 4 печати
                    $vedun = $maya['stamp'] - 4;
                    if ($vedun <= 0) {
                        $vedun = 20 + $vedun;
                    }
                    break;
            }
        }

        // Оккультный учитель
        {
            $okkult = 21 - $maya['stamp'];
            $okkultTon = 14 - $maya['ton'];
        }
        ?>
        <style>
            .oracul .item {
                padding: 0px 10px 10px 10px;
                text-align: center;
            }

            .glyphicon-question-sign {
                opacity: 0.3;
            }
        </style>
        <div class="panel-heading">Наука о времени</div>
        <div class="panel-body">
            <div id="orakul-div" class="col-lg-4">
                <table id="orakul-table" class="oracul">
                    <tr>
                        <td></td>
                        <td id="vedun" class="item">
                            <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                                 class="ton"><br>
                            <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $vedun ?>.gif" alt="" class="stamp"
                                 data-date="2014-03-03">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td id="antipod" class="item">
                            <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                                 class="ton"><br>
                            <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $antipod ?>.gif" alt="" class="stamp"
                                 data-date="2014-03-03">
                        </td>
                        <td id="today" class="item">
                            <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                                 class="ton"><br>
                            <a class="popup-with-zoom-anim" href="#small-dialog">
                                <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $maya['stamp'] ?>.gif" alt=""
                                     class="stamp"
                                     data-date="<?= $birthDate ?>">
                            </a>
                        </td>
                        <td id="analog" class="item">
                            <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                                 class="ton"><br>
                            <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $analog ?>.gif" alt="" class="stamp"
                                 data-date="2014-03-03">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td id="okkult" class="item">
                            <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $okkultTon ?>.gif" alt="" width="20"
                                 class="ton"><br>
                            <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $okkult ?>.gif" alt="" class="stamp"
                                 data-date="2014-03-03">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <?php
            $this->registerJs(<<<JS
var magnificPopupOptions = {
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',

            callbacks: {
                beforeOpen: function(e,i) {
                    //var modalDialog = $('#small-dialog');
                    //modalDialog.html('123');
                }
            }
        };
                        $('.popup-with-zoom-anim').magnificPopup(magnificPopupOptions);

JS
);
            ?>
            <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                <h1>Dialog example</h1>
                <p>This is dummy copy. It is not meant to be read. It has been placed here solely to demonstrate the look and feel of finished, typeset text. Only for show. He who searches for meaning here will be sorely disappointed.</p>
            </div>

            <div class="col-lg-8">
                <table class="table table-striped table-hover">
                    <tr>
                        <?php $this->registerJs(<<<JS
    $('.glyphicon-question-sign').popover();
JS
                        )?>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="Кин Судьбы, который состоит из тона и печати. Это основная энергия, которая дана человеку от рождения."></span>
                        </td>
                        <td>Кин</td>
                        <td><?= $maya['kin'] ?></td>
                    </tr>
                    <tr>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="Портал Галактической Активации означает, что этот Кин - день или человек имеет прямую связь с духом и космосом."></span>
                        </td>
                        <td>ПГА</td>
                        <td><?= $maya['nearPortal'] == 0 ? 'Да' : 'Нет' ?></td>
                    </tr>
                    <tr>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="Персональная Галактическая Печать, которая определяет свойства человека, рожденного в этот день. Эта энергия остается с человеком на всю жизнь."></span>
                        </td>
                        <td>Главная печать</td>
                        <td><?= \cs\models\Calendar\Maya::$stampRows[ $maya['stamp'] - 1 ][0] ?></td>
                    </tr>
                    <tr>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="результирующая сила, дающая обертон и движение"></span></td>
                        <td>Ведущая печать</td>
                        <td><?= \cs\models\Calendar\Maya::$stampRows[ $vedun - 1 ][0] ?></td>
                    </tr>
                    <tr>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="поддерживающая, питающая сила, планетарный партнер"></span></td>
                        <td>Аналог</td>
                        <td><?= \cs\models\Calendar\Maya::$stampRows[ $analog - 1 ][0] ?></td>
                    </tr>
                    <tr>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="сила вызова и испытания, балансирующая сила"></span></td>
                        <td>Антипод</td>
                        <td><?= \cs\models\Calendar\Maya::$stampRows[ $antipod - 1 ][0] ?></td>
                    </tr>
                    <tr>
                        <td><span class="glyphicon glyphicon-question-sign" role="button"
                                  data-content="скрытая сила, незримая духовная поддержка"></span></td>
                        <td>Оккультный учитель</td>
                        <td><?= \cs\models\Calendar\Maya::$stampRows[ $okkult - 1 ][0] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php } ?>
</div>

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
