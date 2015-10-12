<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Редактирование профиля';


$this->registerJs(<<<JS
$('.buttonUnLink').click(function (e) {
        if (confirm('Подтвердите отсоединение')) {
            var objectButton = $(this);
            var name = objectButton.data('name');
            ajaxJson({
                url: '/cabinet/profile/unLinkSocialNetWork',
                data: {
                    name: name
                },
                success: function (ret) {
                    var td = objectButton.parent();
                    td.find('*').each(function() {
                        $(this).remove();
                    });
                    td.append($('<a>', {
                        href: '/auth?authclient=' + name,
                        target: '_blank'
                    }).html('Присоединить профиль'));
                }
            });
        }
    });
JS
);

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
            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                <div class="alert alert-success">
                    Успешно обновлено.
                </div>

            <?php else: ?>

                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'layout'  => 'horizontal',
                ]); ?>
                <?= $form->field($model, 'name_first')->label('Имя') ?>
                <?= $form->field($model, 'name_last')->label('Фамилия') ?>
                <?= $form->field($model, 'avatar')->label('Картинка')->widget('cs\Widget\FileUpload2\FileUpload') ?>
                <?= $model->field($form, 'birth_date') ?>
                <?= $model->field($form, 'mission')->textarea(['rows' => 20]) ?>


                <hr class="featurette-divider">
                <div class="form-group">
                    <?= Html::submitButton('Обновить', [
                        'class' => 'btn btn-default',
                        'name'  => 'contact-button',
                        'style' => 'width: 100%;',
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>

            <?php endif; ?>

            <h2 class="page-header">Соц сети</h2>
            <table class="table" style="width:auto;">
                <tr>
                    <td>Facebook</td>
                    <td>
                        <?php if (isset($model->fb_link)) { ?>
                            <a href="<?= $model->fb_link ?>" target="_blank">Профиль</a>
                            <button class="btn btn-default btn-xs buttonUnLink" data-name="facebook"
                                    style="margin-left: 10px;" type="button">Отсоединить
                            </button>
                        <?php } else { ?>
                            <a href="<?= Url::to(['auth/auth', 'authclient' => 'facebook']) ?>" target="_blank">Присоединить
                                профиль</a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Vkontakte</td>
                    <td>
                        <?php if (isset($model->vk_id)) { ?>
                            <a href="https://vk.com/id<?= $model->vk_id ?>" target="_blank">Профиль</a>
                            <button class="btn btn-default btn-xs buttonUnLink" data-name="vkontakte"
                                    style="margin-left: 10px;" type="button">Отсоединить
                            </button>
                        <?php } else { ?>
                            <a href="<?= Url::to(['auth/auth', 'authclient' => 'vkontakte']) ?>" target="_blank">Присоединить
                                профиль</a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-4">
            <?= $this->render('profile_menu/profile_menu') ?>

        </div>
    </div>
</div>



