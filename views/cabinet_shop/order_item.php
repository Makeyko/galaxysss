<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $request app\models\Shop\Request */

$this->title = 'Заказ #' . $request->getId();
$union = $request->getUnion();

?>
<style>
    .timeline {
        list-style: none;
        padding: 20px 0 20px;
        position: relative;
    }
    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }
    .timeline > li {
        margin-bottom: 20px;
        position: relative;
    }
    .timeline > li:before,
    .timeline > li:after {
        content: " ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li:before,
    .timeline > li:after {
        content: " ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li > .timeline-panel {
        width: 46%;
        float: left;
        border: 1px solid #d4d4d4;
        border-radius: 2px;
        padding: 20px;
        position: relative;
        -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    }
    .timeline > li > .timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " ";
    }
    .timeline > li > .timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " ";
    }
    .timeline > li > .timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1.4em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .timeline > li.timeline-inverted > .timeline-panel {
        float: right;
    }
    .timeline > li.timeline-inverted > .timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }
    .timeline > li.timeline-inverted > .timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }
    .timeline-badge.primary {
        background-color: #2e6da4 !important;
    }
    .timeline-badge.success {
        background-color: #3f903f !important;
    }
    .timeline-badge.warning {
        background-color: #f0ad4e !important;
    }
    .timeline-badge.danger {
        background-color: #d9534f !important;
    }
    .timeline-badge.info {
        background-color: #5bc0de !important;
    }
    .timeline-title {
        margin-top: 0;
        color: inherit;
    }
    .timeline-body > p,
    .timeline-body > ul {
        margin-bottom: 0;
    }
    .timeline-body > p + p {
        margin-top: 5px;
    }
</style>
<div class="container">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-4">
            <img src="<?= $union->getImage() ?>" class="thumbnail" width="100%";>
        </div>
        <div class="col-sm-8">
            <h2 class="page-header"><?= $union->getName() ?></h2>
            <?= \yii\grid\GridView::widget([
                'tableOptions' => [
                    'class' => 'table tableMy table-striped table-hover',
                    'width' => 'auto',
                    'style' => 'width: auto;'
                ],
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query'      => $request->getProductList()
                    ,
                    'pagination' => [
                        'pageSize' => 50,
                    ],
                ]),
                'columns' => [
                    'id',
                    [
                        'header' => 'Картинка',
                        'content' => function($item) {
                            $i = \yii\helpers\ArrayHelper::getValue($item, 'image', '');
                            if ($i == '') return '';
                            return Html::img($i, ['width' => 100, 'class' => 'thumbnail', 'style' => 'margin-bottom: 0px;']);
                        }
                    ],
                    'name:text:Наименование',
                    [
                        'header' => 'Цена',
                        'content' => function($item) {
                            return Yii::$app->formatter->asDecimal($item['price'],0);
                        }
                    ],
                    'count:integer:Кол-во',
                ]
            ]) ?>

        </div>
    </div>


    <h2 class="page-header">История заказа</h2>
    <?php $this->registerJs('$(".timeBack").tooltip()'); ?>
    <ul class="timeline">
        <?php foreach($request->getMessages()->all() as $item) { ?>
            <?php
            $side = 'client';
            $liSuffix = '';
            if ($item['direction'] == (($side == 'client')? \app\models\Shop\Request::DIRECTION_TO_CLIENT : \app\models\Shop\Request::DIRECTION_TO_SHOP)) {
                $liSuffix = ' class="timeline-inverted"';
            }
            if (\yii\helpers\ArrayHelper::getValue($item, 'message', '') != '') {
                $type = 'message';
                $header = 'Сообщение';
                $icon = 'glyphicon-envelope';
                $color = 'info';
                $message = $item['message'];
            } else {
                $type = 'status';
                $header = \app\models\Shop\Request::$statusList[$item['status']][$side];
                $icon = \app\models\Shop\Request::$statusList[$item['status']]['timeLine']['icon'];
                $color = \app\models\Shop\Request::$statusList[$item['status']]['timeLine']['color'];
                $message = '';
            }
            ?>
            <li<?= $liSuffix ?>>
                <div class="timeline-badge <?= $color ?>"><i class="glyphicon <?= $icon ?>"></i></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?= $header ?></h4>
                        <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <abbr title="<?= Yii::$app->formatter->asDatetime($item['datetime']) ?>" class="timeBack"><?= \cs\services\DatePeriod::back($item['datetime']) ?></abbr></small></p>
                    </div>
                    <?php if ($message != '') { ?>
                        <div class="timeline-body">
                            <?= nl2br($message); ?>
                        </div>
                    <?php } ?>
                </div>
            </li>
        <?php } ?>
        <li class="timeline-inverted">
            <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Выставлен счет на оплату</h4>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 часов назад</small></p>
                </div>
                <div class="timeline-body">
                    <p>Стоимость дотавки составит 500 руб.</p>
                    <p>Итого вам необходимо оплатить 2 500 руб.</p>
                </div>
            </div>
        </li>
        <li>
            <div class="timeline-badge success"><i class="glyphicon glyphicon-credit-card"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Заказ оплачен</h4>
                </div>
                <div class="timeline-body">
                    <p>Я оплатил через сбербанк.</p>
                </div>
            </div>
        </li>
        <li>
            <div class="timeline-badge info"><i class="glyphicon glyphicon-envelope"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Сообщение</h4>
                </div>
                <div class="timeline-body">
                    <p>А как сделать Акселератор мозга Если я ничего не знаю, ведь все же знают что Бог везде но я его не вижу, и тогда получается что нужно делать что то</p>
                </div>
            </div>
        </li>
        <li class="timeline-inverted">
            <div class="timeline-badge info"><i class="glyphicon glyphicon-envelope"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Сообщение</h4>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 часов назад</small></p>
                </div>
                <div class="timeline-body">
                    <p>А как сделать Акселератор мозга Если я ничего не знаю, ведь все же знают что Бог везде но я его не вижу, и тогда получается что нужно делать что то</p>
                </div>
            </div>
        </li>

        <li>
            <div class="timeline-badge info"><i class="glyphicon glyphicon-floppy-disk"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Mussum ipsum cacilds</h4>
                </div>
                <div class="timeline-body">
                    <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                    <hr>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>

        <li class="timeline-inverted">
            <div class="timeline-badge success"><i class="glyphicon glyphicon-thumbs-up"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Заказ выполнен</h4>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 часов назад</small></p>
                </div>
            </div>
        </li>
    </ul>
    <button class="btn btn-info">Отправить сообщение</button>
</div>
