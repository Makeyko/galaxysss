<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use \yii\helpers\ArrayHelper;

/* @var $this  \yii\web\View */
/* @var $model \app\models\Form\ProfileHumanDesignCalc */


$this->title = 'Дизайн Человека';

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

        <div class="col-lg-8">
            <?php if ($user->hasHumanDesign()): ?>
                <?php $humanDesign = $user->getHumanDesign();

                $this->registerJs(<<<JS
$('.buttonDelete').click(function(){
    ajaxJson({
            url: '/cabinet/profile/humanDesign/delete',
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
                    <div class="panel-heading">Дизайн Человека

                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs buttonDelete" >
                                Удалить и пересчитать
                            </button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <img src="<?= $humanDesign->getImage() ?>" style="width: 100%;">
                        <table class="table table-striped table-hover" style="width: auto;" align="center">
                            <tr>
                                <td>Тип</td>
                                <td>
                                    <a href="<?= \app\modules\HumanDesign\calculate\YourHumanDesignRu::$links['type'][$humanDesign->type->href] ?>">
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
                    </div>
                </div>

            <?php else: ?>
                <p>Для того чтобы расчитать Дизайн Человека вам необходимо заполнить следующие данные</p>
                <!--                Форма подключения дизайна человека -->
                <div class="col-lg-8 row">
                    <?php
                    $this->registerJs(<<<JS
    $('#profilehumandesigncalc-country').on('change', function(e) {
        ajaxJson({
            url: '/cabinet/profile/humanDesign/ajax',
            data: {
                id: $(this).val()
            },
            success: function(ret) {
                // убираю все элементы
                $('#profilehumandesigncalc-town option').each(function(i,v) {
                    $(this).remove();
                });
                var townSelect = $('#profilehumandesigncalc-town');
                if (ret.items.length == 1) {
                    $('.field-profilehumandesigncalc-town').hide();

                    townSelect.append(
                        $('<option>', {
                            value: ret.items[0].id,
                            selected: 'selected'
                        }).html(ret.items[0].title)
                    );
                } else {
                    $('.field-profilehumandesigncalc-town').show();
                    townSelect.append(
                        $('<option>', {
                            value: 0,
                            selected: 'selected'
                        }).html('Ничего не выбрано')
                    );
                    $('.field-profilehumandesigncalc-town label').html(ret.item.sub_type);
                    $.each(ret.items, function(i,v){
                        townSelect.append(
                            $('<option>', {
                                value: v.id
                            }).html(v.title)
                        );
                    });
                }
            }
        })
    });
JS
                    );
                    $form = ActiveForm::begin([
                        'id' => 'contact-form',
                        'enableAjaxValidation' =>true,
                    ]); ?>

                    <?= $model->field($form, 'date') ?>
                    <?= $model->field($form, 'time') ?>
                    <?= $model->field($form, 'country')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\HD::query()->select('id,title')->orderBy(['title' => SORT_ASC])->all(), 'id', 'title')) ?>
                    <?= $model->field($form, 'town')->dropDownList(\yii\helpers\ArrayHelper::merge([0 => 'Ничего не выбрано'], \yii\helpers\ArrayHelper::map(\app\models\HDtown::query(['country_id' => $model->country])->select('id,title')->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'))) ?>

                    <div class="form-group">
                        <hr>
                        <?= Html::submitButton('Далее', [
                            'class' => 'btn btn-primary',
                            'name'  => 'contact-button',
                            'style' => 'width:100%',
                            'id'    => 'buttonNext'
                        ]) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <!--                /Форма подключения дизайна человека -->

            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <?= $this->render('profile_menu/profile_menu') ?>

        </div>

    </div>


</div>
