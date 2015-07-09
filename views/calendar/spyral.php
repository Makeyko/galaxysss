<?php
/** @var $this yii\web\View */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;
use yii\web\View;

$this->title = 'Спираль';

$this->registerJsFile('/js/pages/calendar/spyral.js', [
    'depends' => [
        'app\assets\App\Asset',
        'app\assets\Maya\Asset',
        'yii\web\JqueryAsset',
    ]
]);

$mayaAssetUrl = Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
$this->registerJs("var MayaAssetUrl='{$mayaAssetUrl}';", View::POS_HEAD);

$layoutAssetUrl = Yii::$app->assetManager->getBundle('app\assets\LayoutMenu\Asset')->baseUrl;
$this->registerJs("var LayoutAssetUrl='{$layoutAssetUrl}';", View::POS_HEAD);

?>

<div class="container">

<div class="col-lg-12">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
</div>
<style>
    .oracul .item {
        padding: 0px 10px 10px 10px;
        text-align: center;
    }

    #wave td {
        padding: 10px 20px 10px 10px;
        text-align: center;
    }

    .wave2 td {
        padding: 0px 20px 0px 20px;
        text-align: center;
        width: 64px;
        height: 64px;
    }

    #wave4 td {
        padding: 5px;
        text-align: center;
    }
</style>

<div class="row">
<div class="col-lg-10">


<div class="col-lg-12">
    <div id="orakul-div" class="col-lg-4">
        <table id="orakul-table" class="oracul">
            <tr>
                <td></td>
                <td id="vedun" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td></td>
            </tr>
            <tr>
                <td id="antipod" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td id="today" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td id="analog" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
            </tr>
            <tr>
                <td></td>
                <td id="okkult" class="item">
                    <img src="<?= $mayaAssetUrl ?>/images/ton/5.gif" alt="" width="20" class="ton"><br>
                    <img src="<?= $mayaAssetUrl ?>/images/stamp3/7.gif" alt="" class="stamp">
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <span style="color: #aaaaaa;">День:</span>
        <input type="text" id="day" class="form-control">
        <span style="color: #aaaaaa;">Месяц:</span>
        <select id="month" class="form-control">
            <option value="1">Январь</option>
            <option value="2">Февраль</option>
            <option value="3">Март</option>
            <option value="4">Апрель</option>
            <option value="5">Май</option>
            <option value="6">Июнь</option>
            <option value="7">Июль</option>
            <option value="8">Август</option>
            <option value="9">Сентябрь</option>
            <option value="10">Октябрь</option>
            <option value="11">Ноябрь</option>
            <option value="12">Декабрь</option>
        </select>
        <span style="color: #aaaaaa;">Год:</span>
        <input type="text" id="year" class="form-control">
        <span id="error" class="label-danger label"></span>
    </div>
</div>
<div class="col-lg-12">

<hr>

<p>Волна</p>



<table id="wave4">
    <tr>
        <td></td>
        <td class="cell-white-9"></td>
        <td class="cell-white-8"></td>
        <td class="cell-white-7"></td>
        <td class="cell-white-6"></td>
        <td class="cell-white-5"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td class="cell-white-10"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-white-4"></td>
        <td></td>
        <td class="cell-red-12"></td>
        <td class="cell-red-11"></td>
        <td class="cell-red-10"></td>
        <td class="cell-red-9"></td>
    </tr>
    <tr>
        <td></td>
        <td class="cell-white-11"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-white-3"></td>
        <td></td>
        <td class="cell-red-13"></td>
        <td></td>
        <td></td>
        <td class="cell-red-8"></td>
    </tr>
    <tr>
        <td></td>
        <td class="cell-white-12"></td>
        <td class="cell-white-13"></td>
        <td></td>
        <td></td>
        <td class="cell-white-2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-red-7"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-white-1"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-red-6"></td>
    </tr>
    <tr class="center">
        <td class="cell-blue-5"></td>
        <td class="cell-blue-4"></td>
        <td class="cell-blue-3"></td>
        <td class="cell-blue-2"></td>
        <td class="cell-blue-1"></td>
        <td class="center"></td>
        <td class="cell-red-1"></td>
        <td class="cell-red-2"></td>
        <td class="cell-red-3"></td>
        <td class="cell-red-4"></td>
        <td class="cell-red-5"></td>
    </tr>
    <tr>
        <td class="cell-blue-6"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-yellow-1"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell-blue-7"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-yellow-2"></td>
        <td></td>
        <td></td>
        <td class="cell-yellow-13"></td>
        <td class="cell-yellow-12"></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell-blue-8"></td>
        <td></td>
        <td></td>
        <td class="cell-blue-13"></td>
        <td></td>
        <td class="cell-yellow-3"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-yellow-11"></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell-blue-9"></td>
        <td class="cell-blue-10"></td>
        <td class="cell-blue-11"></td>
        <td class="cell-blue-12"></td>
        <td></td>
        <td class="cell-yellow-4"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-yellow-10"></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="cell-yellow-5"></td>
        <td class="cell-yellow-6"></td>
        <td class="cell-yellow-7"></td>
        <td class="cell-yellow-8"></td>
        <td class="cell-yellow-9"></td>
        <td></td>
    </tr>
</table>


<hr>
<table class="wave2">
    <tr>
        <td class="wave-cell-1"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="wave-cell-2"></td>
        <td></td>
        <td></td>
        <td class="wave-cell-13"></td>
        <td class="wave-cell-12"></td>
    </tr>
    <tr>
        <td class="wave-cell-3"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="wave-cell-11"></td>
    </tr>
    <tr>
        <td class="wave-cell-4"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="wave-cell-10"></td>
    </tr>
    <tr>
        <td class="wave-cell-5"></td>
        <td class="wave-cell-6"></td>
        <td class="wave-cell-7"></td>
        <td class="wave-cell-8"></td>
        <td class="wave-cell-9"></td>
    </tr>
</table>
<hr>
<table id="wave">
    <tr>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
        <td><img src="" alt="" class="ton" width="20"><br/><img src="" alt="" class="stamp" width="20"><br>

            <div class="kin"></div>
        </td>
    </tr>
</table>
<hr>
<p><b>Песня дня</b></p>
<p id="pesnya"></p>


<hr>
<?= $this->render('../blocks/share', [
    'image'       => \yii\helpers\Url::to('/images/calendar/orakul/share.jpg' , true),
    'url'         => \yii\helpers\Url::current([], true),
    'title'       => $this->title,
    'description' => 'Прочтение Оракула Кина Судьбы или Кина дня – это передача импульса (переход на новый уровень сознания, новую частоту вибраций) и введение в космологию времени и синхронный планетарный порядок. ',
]) ?>
</div>
<?= $this->render('_menu') ?>
</div>


</div>