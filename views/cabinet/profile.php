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
$this->params['breadcrumbs'][] = $this->title;



$this->registerJsFile('/js/pages/cabinet/profile.js', ['depends' => [
    'app\assets\App\Asset',
]]);

?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                <div class="alert alert-success">
                    Успешно обновлено.
                </div>

            <?php else: ?>

                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?= $form->field($model, 'name_first')->label('Имя') ?>
                <?= $form->field($model, 'name_last')->label('Фамилия') ?>
                <?= $form->field($model, 'avatar')->label('Картинка')->widget('cs\Widget\FileUpload2\FileUpload') ?>
                <?= $model->field($form, 'birth_date') ?>

                <table class="table" style="width:auto;">
                    <tr>
                        <td>Facebook</td>
                        <td>
                            <?php if (isset($model->fb_link)) { ?>
                                <a href="<?= $model->fb_link ?>" target="_blank">Профиль</a>
                                <button class="btn btn-default btn-xs buttonUnLink" data-name="facebook" style="margin-left: 10px;" type="button">Отсоединить</button>
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
                                <button class="btn btn-default btn-xs buttonUnLink" data-name="vkontakte" style="margin-left: 10px;" type="button">Отсоединить</button>
                            <?php } else { ?>
                                <a href="<?= Url::to(['auth/auth', 'authclient' => 'vkontakte']) ?>" target="_blank">Присоединить
                                    профиль</a>
                            <?php } ?>
                        </td>
                    </tr>
                </table>

                <hr class="featurette-divider">
                <div class="form-group">
                    <?= Html::submitButton('Обновить', [
                        'class' => 'btn btn-default',
                        'name' => 'contact-button',
                        'style' => 'width: 100%;',
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>

            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <div class="list-group">
                <a href="<?= Url::to(['cabinet/profile']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile']) == Url::to()) { echo ' active'; } ?>"> Профиль </a>
                <a href="<?= Url::to(['cabinet/profile_subscribe']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile_subscribe']) == Url::to()) { echo ' active'; } ?>"> Рассылки </a>
            </div>
        </div>
    </div>
</div>
