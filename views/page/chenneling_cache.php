<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $items array gs_chaneling_list.* */

$this->title = 'Послания';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(<<<JS
    $('#buttonSearchChanneling').click(function() {
        var term = $('#inputSearchChanneling').val();
        if (term == '') return;
        var url = '/chenneling/search?term=' + encodeURIComponent(term);
        window.location = url;
    });
JS
);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <h1 style="margin-bottom: 0px; margin-top: 40px; margin-left: 15px;">Послания</h1>
        </div>
        <div class="col-sm-6">
            <div class="input-group" style="margin-top: 45px;">
                <?= \yii\jui\AutoComplete::widget([
                    'model' => new \app\models\Form\ChennelingSearch(),
                    'attribute' => 'search',
                    'clientOptions' => [
                        'source' => new \yii\web\JsExpression(<<<JS
function( request, response ) {
    ajaxJson({
        url: '/chenneling/search_ajax',
        data: {
            term: request.term
        },
        success: function(ret) {
            response(ret);
        }
    });
     }
JS
),
                        'select' => new \yii\web\JsExpression(<<<JS
function(event, ui) {
    var url = ui.item.date;
    url = url.replace('-', '/');
    url = url.replace('-', '/');
    url = '/chenneling/' + url + '/' + ui.item.id_string;
    window.location = url;
}
JS
)
                    ],
                    'options' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Искать по названию...',
                        'id' => 'inputSearchChanneling',
                    ]
                ]);
                ?>
                <span class="input-group-btn">
                <button class="btn btn-default" id="buttonSearchChanneling"
                type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </div>
    </div>
    <hr style="margin-bottom: 20px; margin-top: 9px; margin-left: 15px;">


    <!-- /.row -->
    <div id="channelingList">
        <?= $this->render('chenneling_cache_list', ['list' => $list]); ?>
    </div>
    <div id="chennelingPages">
        <?php foreach ($pages['list'] as $num) { ?>
            <a href="<?= Url::current(['page' => $num]) ?>"><?= $num ?></a>
        <?php } ?>
    </div>
</div>