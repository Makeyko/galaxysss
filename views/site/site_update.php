<?php

use yii\helpers\Url;
use app\services\GsssHtml;
use yii\helpers\Html;

/** @var array $list gs_site_update */
/** @var \yii\web\View $this  */

$this->title = 'Обновления';

$url = Url::to(['site/site_update_ajax']);
$this->registerJs(<<<JS
    $('.buttonType').click(function() {
        var that = $(this);
        ajaxJson({
            url: '{$url}',
            data: {
                id: that.data('id')
            },
            success: function(ret) {
                $('#listType a').each(function(){
                    $(this).removeClass('active');
                });
                that.addClass('active');
                $('#updateList').html(ret);
            }
        })
    });
JS
)
?>

<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="col-lg-6" id="updateList">
        <?= $this->render('site_update_ajax', [
            'list' => $list,
        ]) ?>
    </div>
    <div class="col-lg-6">
        <div class="list-group" id="listType">
            <?php foreach(\app\models\SiteUpdateItem::$names as $key => $name) { ?>
            <a href="javascript:void(0);" class="list-group-item buttonType" data-id="<?= $key ?>">
                <?= $name ?>
            </a>
            <?php } ?>
        </div>
    </div>
</div>