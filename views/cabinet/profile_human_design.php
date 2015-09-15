<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;

/* @var $this yii\web\View */
/* @var $items array gs_hd.* */


$this->title = 'Дизайн Человека';
$this->params['breadcrumbs'][] = $this->title;

\app\assets\FuelUX\Asset::register($this);

$items = \yii\helpers\Json::encode($items);
$this->registerJs(<<<JS
    var items = {$items};
    var geocoder = new google.maps.Geocoder();
    var ret = [];
    var bounds;
    var item;
    findLocation(0);

    function findLocation(i)
    {
        var v = items[i];
        var address = v.name + ', ' + v.town_name;
        // делаю запрос к Google для поиск координат места. То есть ищу координты по названию места
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var isExistEa = false;
                for(d in results[0].geometry.bounds) {
                    if (d == 'Ea') {
                        isExistEa = true;
                    }
                }
                if (isExistEa == false) {
                    item = {
                        i: i,
                        id: v.town_id,
                        address: address,
                        resultLength: results.length,
                        bounds: 'error',
                        results: results
                    };
                } else {
                    bounds =  {
                       latMin: results[0].geometry.bounds.Ea.j,
                       latMax: results[0].geometry.bounds.Ea.G,
                       lngMin: results[0].geometry.bounds.Ja.G,
                       lngMax: results[0].geometry.bounds.Ja.j
                    };

                    item = {
                        i: i,
                        id: v.town_id,
                        address: address,
                        resultLength: results.length,
                        bounds: bounds,
                        results: results
                    };
                }

                console.log(item);
                ret.push(item);

            } else {
                end();
            }
            if ((i+1) < items.length) {
                i++;
                findLocation(i);
            } else {
                end();
            }
        })
    }

    function end()
    {
        console.log(ret);
        ajaxJson({
            url: '/cabinet/profile/hd_ajax',
            data: {
                data: ret
            },
            success: function(ret) {
                console.log('ok');
            }
        })
    }
JS
);


/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
?>
<div class="container">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?php if ($user->hasHumanDesign()): ?>

                <div class="panel panel-default">
                    <div class="panel-heading">Дизайн Человека</div>
                    <div class="panel-body">
                        <img src="<?= $user->getField('human_design_image') ?>" style="width: 100%;">
                        <?php $humanDesign = $user->getHumanDesign() ?>
                        <table class="table table-striped table-hover">
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>

            <?php else: ?>
                <p>Для того чтобы расчитать Дизайн Человека вам необходимо заполнить следующие данные</p>
<!--                Форма подключения дизайна человека -->
                <div class="col-lg-8 row">
                    <?php
                    $model = new \app\models\Form\ProfileHumanDesignCalc();
                    $form = ActiveForm::begin([
                        'id' => 'contact-form',
                    ]); ?>

                    <?= $model->field($form, 'date') ?>
                    <?= $model->field($form, 'time') ?>
                    <?= $model->field($form, 'point') ?>

                    <div class="form-group">
                        <hr>
                        <?= Html::button('Далее', [
                            'class' => 'btn btn-default',
                            'name'  => 'contact-button',
                            'style' => 'width:100%',
                            'id'    => 'buttonNext'
                        ]) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <!--                /Форма подключения дизайна человека -->

            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <div class="list-group">
                <a href="<?= Url::to(['cabinet/profile']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile']) == Url::to()) { echo ' active'; } ?>"> Профиль </a>
                <a href="<?= Url::to(['cabinet/profile_subscribe']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile_subscribe']) == Url::to()) { echo ' active'; } ?>"> Рассылки </a>
                <a href="<?= Url::to(['cabinet/profile_human_design']) ?>" class="list-group-item<?php if (Url::to(['cabinet/profile_human_design']) == Url::to()) { echo ' active'; } ?>"> Дизайн Человека </a>
            </div>
        </div>
    </div>


</div>
