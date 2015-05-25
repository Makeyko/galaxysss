<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

$this->title = 'Мои новости';

$this->registerJsFile('/js/pages/admin/news.js', ['depends' => [
    'app\assets\App\Asset',
    'app\assets\ModalBoxNew\Asset'
]]);
?>

<div class="container">
    <div class="page-header">
        <h1>Мои новости</h1>
    </div>


    <div class="col-lg-6">
        <?php
        $c = 1;
        foreach($items as $item) {?>
            <a href="<?= Url::to(['admin/news_edit', 'id' => $item['id'] ])?>" class="list-group-item" id="newsItem-<?= $item['id'] ?>">
                <h4><?= $item['header'] ?></h4>

                <div class="row">
                    <div class="col-lg-3">
                        <?php if($item['img'].'' != '') { ?>
                            <img src="<?= $item['img'] ?>" class="thumbnail" width="80">
                        <?php } ?>
                    </div>

                    <div class="col-lg-9">
                        <?= Html::tag('span', GsssHtml::dateString($item['date_insert']), ['style' => 'font-size: 80%; margin-bottom:10px; color: #c0c0c0;'])   ?>
                        <br>
                        <?= \cs\services\Str::sub(strip_tags ($item['content']) , 0 , 200) . '...'  ?>
                        <br>
                        <br>
                        <button class="btn btn-danger btn-xs buttonDelete" data-id="<?= $item['id']?>">Удалить</button>
                    </div>
                </div>
            </a>
            <?php
            $c++;
        }?>
    </div>




    <div class="row">
        <a href="<?= Url::to(['admin/news_add'])?>" class="btn btn-success">Добавить</a>
    </div>
</div>