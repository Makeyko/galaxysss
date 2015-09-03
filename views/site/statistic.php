<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $lineArray array ['x' => array, 'y' => array[[1,2,3,..],...]] Регистрация за один день */
/* @var $lineArray2 array ['x' => array, 'y' => array[[1,2,3,..],...]] Прирост пользователей общий */

$this->title = 'Статистика';
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <h2 class="page-header">Регистрация за один день</h2>
    <?= \cs\Widget\ChartJs\Bar::widget([
        'width'     => 800,
        'lineArray' => $lineArray,
        'colors' => [
            [
                'label'                => "My First dataset",
                'fillColor'            => "rgba(220,220,220,1)",
                'strokeColor'          => "rgba(220,220,220,1)",
                'pointColor'           => "rgba(220,220,220,1)",
                'pointStrokeColor'     => "#fff",
                'pointHighlightFill'   => "#fff",
                'pointHighlightStroke' => "rgba(220,220,220,1)",
            ],
        ]
    ])?>
    <h2 class="page-header">Прирост пользователей общий</h2>
    <?= \cs\Widget\ChartJs\Line::widget([
        'width'     => 800,
        'lineArray' => $lineArray2,
    ])?>

</div>
