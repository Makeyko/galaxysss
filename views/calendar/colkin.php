<?php
/** @var $this yii\web\View */
/** @var array $days двумерный массив [строка от 1][колонка от 1]
 * [
 * 'ton' => int от 1
 * 'kin' => int от 1
 * 'stamp' => int от 1
 * 'isPortal' => bool
 * 'day' => int
 * 'month' => int
 * 'year' => int
 * ]
 */

use cs\models\Calendar\Maya;
use app\services\GsssHtml;
use yii\helpers\Url;

$this->title = 'Цолькин';

$this->registerJs("$('.js-stamp').tooltip()");

$ajax = Url::to(['calendar/colkin_more']);
$this->registerJs(<<<JS
$('#buttonShow').click(function(){
    $('#buttonShow').addClass('active');
    $('#buttonHide').removeClass('active');
    $('.dates').show();
});
$('#buttonHide').click(function(){
    $('#buttonShow').removeClass('active');
    $('#buttonHide').addClass('active');
    $('.dates').hide();
});

var functionMore = function() {
    var me = $(this);
    ajaxJson({
        url: '{$ajax}',
        data: {
            date: $('#lastDate').html()
        },
        beforeSend: function () {
            me.html($('#ajaxLoader').html());
        },
        success: function(ret) {
            var h = $(ret.html);
            h.find('.js-stamp').tooltip();
            me.parent().append(h);
            me.remove();
            $('#lastDate').html(ret.nextDate);
            $('#more').click(functionMore);
        }
    });
};
$('#more').click(functionMore);
JS
);
$mayaAssetUrl = \Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
?>
<div class="container">


    <div class="col-lg-12">
        <h1 class="page-header">Цолькин</h1>
    </div>
    <div id="lastDate" style="display: none"><?= $nextDate ?></div>
    <div id="ajaxLoader" style="display: none"><img style="padding-left: 10px;padding-right: 10px;"
             src="<?= \Yii::$app->assetManager->getBundle(\app\assets\App\Asset::className())->baseUrl ?>/images/ajax-loader.gif"
             id=""></div>



    <div class="col-lg-10">
        <div class="btn-group" role="group" aria-label="Даты">
            <button type="button" class="btn btn-default" id="buttonShow">Показать даты</button>
            <button type="button" class="btn btn-default active" id="buttonHide">Скрыть даты</button>
        </div>
        <?= $this->render('colkin_more', ['days' => $days]) ?>
    </div>
    <?= $this->render('_menu') ?>



</div>
