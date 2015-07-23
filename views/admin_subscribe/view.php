<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;
use cs\services\Str;

/* @var $this yii\web\View */
/* @var $item array рассылки gs_subscribe_history */

$this->title = $item['subject'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>
    </div>

    <div class="col-lg-8">
        <?= $item['content'] ?>
    </div>

</div>