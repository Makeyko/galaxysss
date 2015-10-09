<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $userRod app\models\UserRod */
/* @var $breadcrumbs array */

$this->title = $userRod->getName();
if (is_null($this->title)) {
    $this->title = '?';
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div>
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        <?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => $breadcrumbs,
            'home'  => [
                'name' => 'я',
                'url'  => \yii\helpers\Url::to(['site/user', 'id' => $userRod->getField('user_id')])
            ]
        ]) ?>
        <hr>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <img src="<?= $userRod->getImage(); ?>" class="thumbnail" width="100%"/>
        </div>
        <div class="col-lg-8">
            <table class="table table-striped table-hover" style="width: auto">
                <tr>
                    <td>Пол</td>
                    <td><span class="label label-success"><?= ($userRod->getGender() > 0)? 'Мужской' : 'Женский' ?></span></td>
                </tr>
                <tr>
                    <td>Колено</td>
                    <td><?= $userRod->getKoleno() ?></td>
                </tr>
                <tr>
                    <td>Дата прихода</td>
                    <td style="font-family: 'courier new'"><?= ($userRod->getField('date_born')) ? Yii::$app->formatter->asDate($userRod->getField('date_born')) : '' ?></td>
                </tr>
                <tr>
                    <td>Дата ухода</td>
                    <td style="font-family: 'courier new'"><?= ($userRod->getField('date_death')) ? Yii::$app->formatter->asDate($userRod->getField('date_death')) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
