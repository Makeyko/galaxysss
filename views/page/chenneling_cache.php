<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $items array gs_chaneling_list.* */

$this->title = 'Послания';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <style>

    </style>

    <div class="col-lg-12">
        <h1 class="page-header">Послания</h1>
    </div>
    <div id="channelingList">
        <?= $this->render('chenneling_cache_list', ['list' => $list]); ?>
    </div>
    <div class="col-lg-12" id="chennelingPages">
        <nav>
            <ul class="pagination">
                <?php foreach ($pages['list'] as $num) { ?>
                    <?php if ($num == $pages['current']) {?>
                        <li class="active"><a href="<?= Url::current(['page' => $num]) ?>"><?= $num ?></a></li>
                    <?php } else { ?>
                        <li><a href="<?= Url::current(['page' => $num]) ?>"><?= $num ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>