<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Лог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

<div class="site-login">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <pre>
        <?= Html::encode($log) ?>

    </pre>



</div>
</div>