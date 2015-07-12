<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $items array gs_chaneling_list.* */

$this->title = 'Новости Земли';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>

    <?php
    foreach($items as $item) {
        echo \app\services\GsssHtml::newsItem($item);
    }
    ?>

</div>