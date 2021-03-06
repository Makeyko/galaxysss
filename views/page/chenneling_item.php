<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;

/* @var $this yii\web\View */
/* @var $item array поля послания */
/* @var $nearList array похожие послания */

$this->title = $item['header'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
    </div>

    <div class="col-lg-8" style="padding-bottom: 50px;">
        <?= $item['content'] ?>
        <hr>
        <?php if (isset($item['source'])): ?>
            <?php if ($item['source'] != ''): ?>
                <?= Html::a('Ссылка на источник »', $item['source'], [
                    'class'  => 'btn btn-primary',
                    'target' => '_blank',
                ]) ?>
            <?php endif; ?>
        <?php endif;
        $image = $item['img'] . '';
        ?>

        <?= $this->render('../blocks/share', [
            'image'       => ($image != '')? \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($item['img'], true), false) : '' ,
            'url'         => Url::current([], true),
            'title'       => $item['header'],
            'description' => $item['description'],
        ]) ?>
        <?= $this->render('../blocks/yandexMoney2') ?>
        <!--                Комментарии -->
        <!--                --><?//= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_CHENNELING, $item['id']); ?>

    </div>

    <div class="col-lg-4">
        <?php if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isMarketing', 0) == 1 && date('Y-m-d') < '2015-10-30') { ?>
            <?= $this->render('../blocks/reklama') ?>
        <?php } ?>

        <?php foreach ($nearList as $item) { ?>
            <?= $this->render('../blocks/chenneling', [
                'item'     => $item,
            ]) ?>
        <?php } ?>
    </div>

</div>