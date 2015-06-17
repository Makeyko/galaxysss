<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;

/* @var $this yii\web\View */
/* @var $item array */

$this->title = $item['header'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('#share').popover()");
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
                    'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($item['image'], true), false) ,
                    'url'         => Url::current([], true),
                    'title'       => $item['header'],
                    'description' => trim(Str::sub(strip_tags($item['content']), 0, 200)),
                ]) ?>
                <?= \app\modules\Comment\Service::render(\app\modules\Comment\Model::TYPE_CHENNELING, $item['id']); ?>


            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="thumbnail">
                        <img alt="100%x200"
                             src="/upload/FileUpload2/gs_chaneling_list/00000002/small/img.jpg"
                             style="width: 100%; display: block;">

                        <div class="caption">
                            <h3>Thumbnail label</h3>

                            <p>Проект Веста создан именно для таких людей. с целью оповещения о тонко-энергетической
                                работе в космосе и на земле и для синхронизации такой работы между группами сильных
                                продвинутых сознаний, стремящихся и реально готовых содействовать становлению нового
                                мира, мира правления Духа. </p>

                            <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#"
                                                                                               class="btn btn-default"
                                                                                               role="button">Button</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="thumbnail">
                        <img alt="100%x200"
                             src="/upload/FileUpload2/gs_chaneling_list/00000002/small/img.jpg"
                             style="height: 200px; width: 100%; display: block;">

                        <div class="caption">
                            <h3>Thumbnail label</h3>

                            <p>Проект Веста создан именно для таких людей. с целью оповещения о тонко-энергетической
                                работе в космосе и на земле и для синхронизации такой работы между группами сильных
                                продвинутых сознаний, стремящихся и реально готовых содействовать становлению нового
                                мира, мира правления Духа. </p>

                            <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#"
                                                                                               class="btn btn-default"
                                                                                               role="button">Button</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>