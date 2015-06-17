<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $items array gs_chaneling_list.* */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <div class="site-about">
        <div class="page-header">
            <h1>Новости</h1>
        </div>

        <?php
        foreach($items as $item) {
            echo \app\services\GsssHtml::newsItem($item);
        }
        ?>

    </div>
</div>