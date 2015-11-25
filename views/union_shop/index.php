<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;
use yii\widgets\Breadcrumbs;

/** @var $this yii\web\View */
/** @var $union       \app\models\Union */
/** @var $shop        \app\models\Shop */
/** @var $breadcrumbs array */
/** @var $rows        array дерево магазина */
/** @var $category    \app\models\UnionCategory */

$this->title = 'Магазин';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
        <?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => $breadcrumbs
        ]) ?>
        <hr>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <img class="img-thumbnail" src="<?= $union->getImage() ?>">
        </div>
        <div class="col-lg-8">
            Магазин

            <?= $this->render('_tree', [
                'rows'     => $rows,
                'category' => $category->getField('id_string'),
                'id'       => $union->getId(),
            ]) ?>

            <hr>
            <?= $this->render('../blocks/share', [
                'image'       => \cs\Widget\FileUpload2\FileUpload::getOriginal(Url::to($union->getImage(), true), false),
                'url'         => Url::current([], true),
                'title'       => $union->getName() . '. Магазин',
                'description' => 'ff',
            ]) ?>
        </div>
    </div>


</div>