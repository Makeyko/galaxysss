<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;
use yii\widgets\Breadcrumbs;

/** @var $this yii\web\View */
/** @var $item array */
/** @var $nearList array похожие статьи  */
/** @var $category string категория   */
/** @var array $breadcrumbs */

$this->title = $item['header'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('#share').popover()");

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <?=  \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => $breadcrumbs
        ]) ?>
        <hr>
    </div>
    <div class="col-lg-8">
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
        $image = $item['image'];
        ?>

        <?= $this->render('../blocks/share', [
            'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($item['image'], true), false),
            'url'         => Url::current([], true),
            'title'       => $item['header'],
            'description' => trim(Str::sub(strip_tags($item['content']), 0, 200)),
        ]) ?>
        <?//= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_ARTICLE, $item['id']); ?>


    </div>
    <div class="col-lg-4">
        <?php if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isMarketing', 0) == 1 && date('Y-m-d') < '2015-10-30') { ?>
            <?= $this->render('../blocks/reklama') ?>
        <?php } ?>

        <?php foreach ($nearList as $item) { ?>
            <?= $this->render('../blocks/article', [
                'item'     => $item,
                'category' => $category,
            ]) ?>
        <?php } ?>
    </div>

</div>