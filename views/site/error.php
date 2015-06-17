<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="container">

    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?php
            if (is_string($message)) {
                echo nl2br(Html::encode($message));
            } elseif (is_array($message)) {
                foreach($message as $item) {
                    echo $item;
                }
            }
            ?>
        </div>


    </div>
</div>