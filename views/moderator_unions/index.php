<?php

use yii\helpers\Url;

$this->title = 'Мои объединения';
$this->registerJsFile('/js/pages/moderator_unions/index.js', [
    'depends' => [
        'app\assets\App\Asset',
        'app\assets\ModalBoxNew\Asset',
    ]
]);

?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header">Объединения</h1>
    </div>


    <div class="col-lg-6">
        <?php
        $c = 1;
        foreach($items as $item) {?>
            <a href="<?= Url::to(['cabinet/objects_edit', 'id' => $item['id'] ])?>" class="list-group-item">
                <button type="button" class="close buttonDelete" aria-label="Close" data-id="<?= $item['id'] ?>"><span aria-hidden="true">&times;</span></button>

                <h4><?= $item['name'] ?></h4>

                <div class="row">
                    <div class="col-lg-3">
                        <img src="<?= $item['img'] ?>" class="thumbnail" width="80">
                    </div>
                    <div class="col-lg-9">
                        <?= \cs\services\Str::sub(strip_tags ($item['description']) , 0 , 200) . '...'  ?>
                        <br>
                        <br>
                        <button class="btn btn-success btn-xs buttonAccept" data-id="<?= $item['id'] ?>">Утвердить</button>
                        <button class="btn btn-danger btn-xs buttonReject" data-id="<?= $item['id'] ?>">Отвергнуть</button>
                    </div>
                </div>
            </a>
            <?php
            $c++;
        }?>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Причина отклонения</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="10"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary buttonSend">Отправить</button>
            </div>
        </div>
    </div>
</div>