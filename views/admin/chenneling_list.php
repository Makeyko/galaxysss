<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\services\GetArticle\Collection;

$this->title = 'Мои ченнелинги';

$this->registerJsFile('/js/pages/admin/chenneling_list.js', [
    'depends' => [
        'app\assets\App\Asset',
        'app\assets\ModalBoxNew\Asset'
    ]
]);
?>

<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>


    <div class="col-lg-6">
        <?php
        $c = 1;
        foreach ($items as $item) {
            ?>
            <a href="<?= Url::to([
                    'admin/chenneling_list_edit',
                    'id' => $item['id']
                ]) ?>" class="list-group-item" id="newsItem-<?= $item['id'] ?>">
                <h4><?= $item['header'] ?></h4>

                <div class="row">
                    <div class="col-lg-3">
                        <?php if ($item['img'] . '' != '') { ?>
                            <img src="<?= $item['img'] ?>" class="thumbnail" width="80">
                        <?php } ?>
                    </div>

                    <div class="col-lg-9">
                        <?= Html::tag('span', GsssHtml::dateString($item['date_insert']), ['style' => 'font-size: 80%; margin-bottom:10px; color: #c0c0c0;']) ?>
                        <br>
                        <?= \cs\services\Str::sub(strip_tags($item['content']), 0, 200) . '...' ?>
                        <br>
                        <br>
                        <button class="btn btn-danger btn-xs buttonDelete" data-id="<?= $item['id'] ?>">Удалить</button>
                        <?php if (\yii\helpers\ArrayHelper::getValue($item, 'is_added_site_update', 0) == 0) { ?>
                            <button class="btn btn-success btn-xs buttonAddSiteUpdate" data-id="<?= $item['id'] ?>">Сделать рассылку</button>
                        <?php } ?>
                    </div>
                </div>
            </a>
            <?php
            $c++;
        }?>
    </div>


    <div class="col-lg-6">
        <div class="row">
            <!-- Split button -->
            <div class="btn-group">
                <a href="<?= Url::to(['admin/chenneling_list_add'])?>" class="btn btn-default">Добавить</a>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach(Collection::getList() as $item) {?>
                        <li><a href="<?= Url::to(['admin/chenneling_list_add_from_page', 'page' => $item['name']])?>">Добавить с <?= $item['title'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <br>
            <br>
            <a href="<?= Url::to(['page/chenneling']) ?>" class="btn btn-default">На сайте</a>
        </div>
    </div>
</div>