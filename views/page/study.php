<?php

use yii\helpers\Url;


$this->title = 'Обучение';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Новейшие космологические представления о Вселенной и человеке</p>
        <p>
            <a href="http://www.i-am-avatar.com/" target="_blank">
                <img src="/images/page/study/i-am-avatar0.jpg" width="100%" class="thumbnail">
            </a>
        </p>
        <a href="http://www.i-am-avatar.com/" target="_blank" class="btn btn-success btn-lg" style="width: 100%; margin-bottom: 80px;">
            Перейти в Школу Богов
        </a>
        <hr>
    </div>


    <?= \app\services\GsssHtml::unionCategoryItems(11) ?>

    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'study');
        } ?>
    <?php } ?>


    <div class="col-lg-12">
        <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/study/8879600072.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'Новейшие космологические представления о Вселенной и человеке',
    ]) ?>
</div>
</div>