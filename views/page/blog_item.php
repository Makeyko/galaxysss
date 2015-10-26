<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;
use yii\widgets\Breadcrumbs;

/** @var $this yii\web\View */
/** @var $item \app\models\Blog */
/** @var $nearList array похожие статьи  */

$this->title = $item->getName();
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('#share').popover()");

\Yii::info([
    \yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isMarketing', 0) == 1 && (date('Y-m-d') < '2015-10-30'),
    \yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isMarketing', 0),
    date('Y-m-d')
], 'gs\\info');
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <?=  \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => [
                [
                    'label' => 'Блог',
                    'url' => ['page/blog'],
                ],
                $item->getName(),
            ]
        ]) ?>
        <hr>
    </div>
    <div class="col-lg-8">
        <?= $item->getField('content') ?>
        <hr>
        <?php
        $source = $item->getField('source', '');
        if ($source): ?>
            <?= Html::a('Ссылка на источник »', $source, [
                'class'  => 'btn btn-primary',
                'target' => '_blank',
            ]) ?>
        <?php endif;
        $image = $item->getImage();
        ?>

        <?= $this->render('../blocks/share', [
            'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($image, true), false),
            'url'         => Url::current([], true),
            'title'       => $item->getName(),
            'description' => $item->getField('description'),
        ]) ?>
        <?//= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_ARTICLE, $item['id']); ?>


    </div>
    <div class="col-lg-4">
        <?php if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isMarketing', 0) == 1 && (date('Y-m-d') < '2015-10-30')) { ?>
            <?= $this->render('../blocks/reklama') ?>
        <?php } ?>

        <?php foreach ($nearList as $item) { ?>
            <?= $this->render('../blocks/blog_near_item', [
                'item'     => new \app\models\Blog($item),
            ]) ?>
        <?php } ?>
    </div>

</div>