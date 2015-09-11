<?php

/** @var array $items */

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новые послания';

$model = new \app\models\Form\Investigator();

?>
<style>
    .selectlist[data-initialize="selectlist"] {
        width: 150px;
    }
</style>
<div class="container">
    <h1 class="page-header"><?= $this->title ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFlash')) {?>
        <p class="alert alert-success">Успешно добавлено</p>
    <?php } else {?>
        <?php $form = ActiveForm::begin([
            'id'      => 'contact-form',
        ]); ?>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Класс</th>
                <th>Ссылка</th>
                <th>Навание</th>
                <th>Действие</th>
            </tr>
            </thead>
            <?php
            $c = 1;
            foreach ($items as $item) {
                ?>
                <tr>

                    <td><?= $item['class'] ?></td>
                    <td>
                        <a
                            class="btn btn-default"
                            href="<?= $item['url'] ?>"
                            target="_blank">Ссылка</a>
                    </td>
                    <td><?= $item['name'] ?></td>
                    <td><?= \cs\Widget\Selectlist\Selectlist::widget([
                            'model' => $model,
                            'attribute' => 'id' . $item['id'],
                            'items' => [
                                2 => 'Добавить',
                                1 => 'Пропустить',
                            ],
                        ]) ?></td>
                </tr>
                <?php
                $c++;
            } ?>
        </table>
        <?= Html::submitButton('Обновить', [
            'class' => 'btn btn-default',
            'name'  => 'contact-button',
            'style' => 'width:100%',
        ]) ?>
        <?php ActiveForm::end(); ?>
    <?php } ?>


</div>