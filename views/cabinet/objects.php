<?php

use yii\helpers\Url;

$this->title = 'Мои объединения';
$this->registerJsFile('/js/pages/cabinet/objects.js', [
    'depends' => [
        'app\assets\App\Asset',
        'app\assets\ModalBoxNew\Asset'
    ]
]);

?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header">Мои объединения</h1>

        <div class="col-lg-6">
            <?php
            $c = 1;
            foreach($items as $item) {?>
                <a href="<?= Url::to(['cabinet/objects_edit', 'id' => $item['id'] ])?>" class="list-group-item">
                    <h4><?= $item['name'] ?></h4>

                    <div class="row">
                        <div class="col-lg-3">
                            <img src="<?= $item['img'] ?>" class="thumbnail" width="80">
                        </div>
                        <div class="col-lg-9">
                            <?= \cs\services\Str::sub(strip_tags ($item['description']) , 0 , 200) . '...'  ?>
                            <br>
                            <?php if ($item['moderation_status'] == 0) { ?>
                                <span class="label label-danger">Отклонено модератором</span>
                                <button class="btn btn-default btn-xs buttonSendModeration" data-id="<?= $item['id'] ?>">Отправить на модерацию</button>
                            <?php } ?>
                            <br>
                            <br>
                            <button class="btn btn-danger btn-xs buttonDelete" data-id="<?= $item['id'] ?>">Удалить</button>
                            <?php if (\yii\helpers\ArrayHelper::getValue($item, 'is_added_site_update', 0) == 0 && \Yii::$app->user->identity->isAdmin()) { ?>
                                <button class="btn btn-success btn-xs buttonAddSiteUpdate" data-id="<?= $item['id'] ?>">Сделать рассылку</button>
                            <?php } ?>
                        </div>
                    </div>
                </a>
                <?php
                $c++;
            }?>
        </div>

        <div class="row">
            <a href="<?= Url::to(['cabinet/objects_add'])?>" class="btn btn-default">Добавить</a>
        </div>
    </div>



</div>