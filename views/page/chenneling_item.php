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

    <div class="site-about">
        <div class="page-header">
            <h1><?= Html::encode($item['header']) ?></h1>
        </div>

        <div class="content">

            <div class="col-lg-8">
                <?= $item['content'] ?>
                <?php if (isset($item['source'])): ?>
                    <?php if ($item['source'] != ''): ?>
                        <?= Html::a('Ссылка на источник »', $item['source'], [
                            'class'  => 'btn btn-primary',
                            'target' => '_blank',
                        ]) ?>
                    <?php endif; ?>
                <?php endif;
                $image = $item['img'];
                ?>

                <?= $this->render('../blocks/share', [
                    'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($item['img'], true), false) ,
                    'url'         => Url::current([], true),
                    'title'       => $item['header'],
                    'description' => trim(Str::sub(strip_tags($item['content']), 0, 200)),
                ]) ?>
<!--                Комментарии -->
<!--                --><?//= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_CHENNELING, $item['id']); ?>


            </div>
            <div class="col-lg-4">
                <?php foreach ($nearList as $item) { ?>
                    <?= $this->render('../blocks/chenneling', [
                        'item'     => $item,
                    ]) ?>
                <?php } ?>
            </div>
        </div>

    </div>
</div>