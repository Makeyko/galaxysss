<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $list array gs_blog.* */

$this->title = 'Блог';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>

    <?php
    foreach($list as $item) {
         echo $this->render('../blocks/blog_item', [
             'item' => new \app\models\Blog($item),
         ]);
    }
    ?>

</div>