<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use \yii\helpers\ArrayHelper;

/* @var $this  \yii\web\View */
/* @var $model \app\models\Form\ProfileHumanDesignCalc */


$this->title = 'Персональная Галактическая Печать';

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
$birthDate = $user->getField('birth_date');

?>
<div class="container">
<div class="col-lg-12">
<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
<?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
    'items' => [
        $this->title
    ],
    'home'  => [
        'name' => 'я',
        'url'  => \yii\helpers\Url::to(['site/user', 'id' => Yii::$app->user->id])
    ]
]) ?>
<hr>

<div class="col-lg-8">
<?php if ($birthDate): ?>
    <?php

    $this->registerJs(<<<JS
$('.buttonDelete').click(function(){
    ajaxJson({
            url: '/cabinet/profile/time/delete',
            success: function(){
                location.reload();
            }
        })
    }
);
JS
    );
    ?>
    <div class="panel panel-default">
    <div class="panel-heading">Персональная Галактическая Печать
    </div>
    <div class="panel-body">
    <div class="col-lg-4" id="orakul-div">
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
        <table id="orakul-table" class="oracul">
            <tr>
                <td></td>
                <td id="vedun" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                         class="ton"><br>
                    <a class="popup-with-zoom-anim" href="#small-dialog">
                        <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $vedun ?>.gif" alt="" class="stamp"
                             data-stamp="<?= $vedun ?>"
                             title="<?= \cs\models\Calendar\Maya::$stampRows[ $vedun - 1 ][0] ?>">
                    </a>
                </td>
                <td></td>
            </tr>
            <tr>
                <td id="antipod" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                         class="ton"><br>
                    <a class="popup-with-zoom-anim" href="#small-dialog">
                        <img src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $antipod ?>.gif" alt="" class="stamp"
                             data-stamp="<?= $antipod ?>"
                             title="<?= \cs\models\Calendar\Maya::$stampRows[ $antipod - 1 ][0] ?>">
                    </a>
                </td>
                <td id="today" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                         class="ton"><br>
                    <a class="popup-with-zoom-anim" href="#small-dialog">
                        <img
                            src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $maya['stamp'] ?>.gif"
                            alt=""
                            class="stamp"
                            data-stamp="<?= $maya['stamp'] ?>"
                            title="<?= \cs\models\Calendar\Maya::$stampRows[ $maya['stamp'] - 1 ][0] ?>"
                            data-date="<?= $birthDate ?>"
                            >
                    </a>
                </td>
                <td id="analog" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $maya['ton'] ?>.gif" alt="" width="20"
                         class="ton"><br>
                    <a class="popup-with-zoom-anim" href="#small-dialog">
                        <img
                            src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $analog ?>.gif"
                            alt=""
                            class="stamp"
                            data-stamp="<?= $analog ?>"
                            title="<?= \cs\models\Calendar\Maya::$stampRows[ $analog - 1 ][0] ?>"
                            >
                    </a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td id="okkult" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/<?= $okkultTon ?>.gif" alt="" width="20"
                         class="ton"><br>
                    <a class="popup-with-zoom-anim" href="#small-dialog">
                        <img
                            src="<?= $mayaAssetUrl ?>/images/stamp3/<?= $okkult ?>.gif"
                            alt=""
                            data-stamp="<?= $okkult ?>"
                            class="stamp"
                            title="<?= \cs\models\Calendar\Maya::$stampRows[ $okkult - 1 ][0] ?>"
                            >
                    </a>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-8">
        <?php
        $path = $this->registerAssetBundle('app\assets\Maya\Asset')->baseUrl;
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
            var thisDayLink = this.items[this.index];
            var thisDayImg = $(thisDayLink).find('img')[0];
            thisDayImg = $(thisDayImg);
            thisDayImg.tooltip('hide');
            console.log(thisDayImg);
            var stamp = thisDayImg.data('stamp');
            var modalDialog = $('#small-dialog');
            modalDialog.html('');
            modalDialog.append($('<h1>', {
                class: 'page-header'
            }).html(GSSS.calendar.maya.stampList[stamp-1][0]));
            modalDialog.append(
                $('<p>').append(
                    $('<img>', {
                        src: '{$path}/images/stamp3/' + stamp + '.gif'
                    })
                )
            );
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][1]));
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][2]));
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][3]));
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][4]));
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][5]));
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][6]));
            modalDialog.append($('<p>').html(GSSS.calendar.maya.stampList[stamp-1][7]));

            }
        }
    };
    $('.popup-with-zoom-anim').magnificPopup(magnificPopupOptions);
    $('img.stamp').tooltip();
JS
        );
        ?>
        <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
            <h1>Dialog example</h1>

            <p>This is dummy copy. It is not meant to be read. It has been placed here solely to demonstrate the look
                and feel of finished, typeset text. Only for show. He who searches for meaning here will be sorely
                disappointed.</p>
        </div>

        <table class="table table-striped table-hover">
            <tr>
                <?php $this->registerJs(<<<JS
        $('.glyphicon-question-sign').popover({
            trigger: 'focus',
            placement: 'left'
        });
JS
                )?>
                <td><span
                        tabindex="0"
                        class="glyphicon glyphicon-question-sign"
                        role="button"
                        data-content="Кин Судьбы, который состоит из тона и печати. Это основная энергия, которая дана человеку от рождения."
                        data-title="Кин"
                        ></span>
                </td>
                <td>Кин</td>
                <td><?= $maya['kin'] ?></td>
            </tr>
            <tr>
                <td><span tabindex="0" class="glyphicon glyphicon-question-sign" role="button"
                          data-title="ПГА"
                          data-content="Портал Галактической Активации означает, что этот Кин - день или человек имеет прямую связь с духом и космосом."></span>
                </td>
                <td>ПГА</td>
                <td><?= $maya['nearPortal'] == 0 ? 'Да' : 'Нет' ?></td>
            </tr>
            <tr>
                <td><span tabindex="0" class="glyphicon glyphicon-question-sign" role="button"
                          data-title="Главная печать"
                          data-content="Персональная Галактическая Печать, которая определяет свойства человека, рожденного в этот день. Эта энергия остается с человеком на всю жизнь."></span>
                </td>
                <td>Главная печать</td>
                <td><?= \cs\models\Calendar\Maya::$stampRows[ $maya['stamp'] - 1 ][0] ?></td>
            </tr>
            <tr>
                <td><span tabindex="0" class="glyphicon glyphicon-question-sign" role="button"
                          data-title="Ведущая печать"
                          data-content="результирующая сила, дающая обертон и движение"></span></td>
                <td>Ведущая печать</td>
                <td><?= \cs\models\Calendar\Maya::$stampRows[ $vedun - 1 ][0] ?></td>
            </tr>
            <tr>
                <td><span tabindex="0" class="glyphicon glyphicon-question-sign" role="button"
                          data-title="Аналог"
                          data-content="поддерживающая, питающая сила, планетарный партнер"></span></td>
                <td>Аналог</td>
                <td><?= \cs\models\Calendar\Maya::$stampRows[ $analog - 1 ][0] ?></td>
            </tr>
            <tr>
                <td><span tabindex="0" class="glyphicon glyphicon-question-sign" role="button"
                          data-title="Антипод"
                          data-content="сила вызова и испытания, балансирующая сила"></span></td>
                <td>Антипод</td>
                <td><?= \cs\models\Calendar\Maya::$stampRows[ $antipod - 1 ][0] ?></td>
            </tr>
            <tr>
                <td><span tabindex="0" class="glyphicon glyphicon-question-sign" role="button"
                          data-title="Оккультный учитель"
                          data-content="скрытая сила, незримая духовная поддержка"></span></td>
                <td>Оккультный учитель</td>
                <td><?= \cs\models\Calendar\Maya::$stampRows[ $okkult - 1 ][0] ?></td>
            </tr>
        </table>
    </div>
    </div>
    </div>

<?php else: ?>
    <p>Для того чтобы расчитать Персональную Галактическую Печать вам необходимо заполнить следующие данные</p>
    <!--  Форма подключения дизайна человека -->
    <div class="col-lg-8 row">
        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
        ]); ?>

        <?= $model->field($form, 'birth_date') ?>

        <hr>
        <?= Html::submitButton('Расчитать', [
            'class' => 'btn btn-primary',
            'name'  => 'contact-button',
            'style' => 'width:100%',
            'id'    => 'buttonNext'
        ]) ?>

        <?php ActiveForm::end(); ?>
    </div>
    <!-- /Форма подключения дизайна человека -->

<?php endif; ?>
</div>
<div class="col-lg-4">
    <?= $this->render('profile_menu/profile_menu') ?>

</div>

</div>


</div>
