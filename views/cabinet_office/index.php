<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

$this->title = 'Офисы';

$this->registerJs(<<<JS
$('.buttonDelete').click(function (e) {
    if (confirm('Подтвердите удаление')) {
        e.preventDefault();
        var id = $(this).data('id');
        ajaxJson({
            url: '/cabinet/officeList/' + id + '/delete',
            success: function (ret) {
                infoWindow('Успешно', function() {
                    $('#newsItem-' + id).remove();
                });
            }
        });
    }
});
JS
);
?>

<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header">Офисы</h1>
    </div>

    <table class="table table-hover">
        <tr id="newsItem-<?= $item['id'] ?>">
            <th>Имя</th>
            <th>Адрес</th>
            <th>lat</th>
            <th>lng</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>
        <?php
        $c = 1;
        foreach ($items as $item) {
            ?>
            <tr id="newsItem-<?= $item['id'] ?>">
                <td><?= $item['name'] ?></td>
                <td><?= $item['point_address'] ?></td>
                <td><?= $item['point_lat'] ?></td>
                <td><?= $item['point_lng'] ?></td>
                <td><?= Html::a('Редактировать', [
                        'cabinet_office/edit',
                        'id' => $item['id'],
                    ], ['class' => 'btn btn-default']) ?></td>
                <td><?= Html::button('Удалить', [
                        'class' => 'btn btn-danger btn-xs buttonDelete',
                        'data' => [
                            'id' => $item['id'],
                        ],
                    ]) ?></td>
            </tr>
            <?php
            $c++;
        }?>
    </table>

    <div class="col-lg-6">
        <div class="row">
            <a href="<?= Url::to(['cabinet_office/add', 'unionId' => $union_id]) ?>" class="btn btn-success">Добавить</a>
        </div>
    </div>
</div>