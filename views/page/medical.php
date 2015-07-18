<?php

use yii\helpers\Url;

$this->title = 'Союз самоисцеления';

?>
<div class="container">
<style>
    .headerUnion {
        height: 70px;
    }


</style>
    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <p class="lead">Союз занимается восстанавлением
            здоровья, настраивает тело на резонанс с высшими контурами сознания, регулирует течение внутренних и внешних
            энергий человека.</p>
        <p><img src="/images/page/medical/parablev121.jpg" width="100%" class="thumbnail"></p>
    </div>


    <?= \app\services\GsssHtml::unionCategoryItems(5) ?>

    <?php if (count($articleList) > 0) { ?>
        <div class="col-lg-12">
            <h2 class="page-header">Статьи</h2>
        </div>
        <?php foreach ($articleList as $item) {
            echo \app\services\GsssHtml::articleItem($item, 'medical');
        } ?>
    <?php } ?>


    <div class="col-lg-12">
    <hr>
    <?= $this->render('../blocks/share', [
        'image'       => Url::to('/images/page/medical/parablev121.jpg', true),
        'url'         => Url::current([], true),
        'title'       => $this->title,
        'description' => 'Союз занимается восстанавлением
            здоровья, настраивает тело на резонанс с высшими контурами сознания, регулирует течение внутренних и внешних
            энергий человека.',
    ]) ?>
</div>
</div>