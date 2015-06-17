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
    <div class="page-header">
        <h1>Мои объединения</h1>
    </div>


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
                        <br>
                        <button class="btn btn-danger btn-xs buttonDelete" data-id="<?= $item['id'] ?>">Удалить</button>
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