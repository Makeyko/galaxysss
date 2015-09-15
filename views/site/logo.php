<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Логотип - Цветок Жизни';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

        <center>
            <p class="center">
                <img src="/images/site/logo/ico.jpg"
                     class="thumbnail"
                     style="width: 100%; max-width: 400px;"
                    />
            </p>
        </center>
        <p>
            «Цветок Жизни» - знак, символ, изображение, которое отображает математический символ бесконечности ∞.
            Символ, «Цветок жизни», так же известен как суфийский лотос.
            В соответствии с Сакральной Геометрией, структура Цветка Жизни состоит из ячеек, «сот»-шестигранников,
            каждая из которых образует узел – Цветок Жизни. Этот символ несет в себе фрактальность, симметричность и
            гармонию. Всю фигуру описывают два круга. Внутренний круг отображает массу Вселенной, внешний круг
            отображает энергетическую оболочку Вселенной.
        </p>

        <div class="col-lg-12 row">
            <center>
                <p class="col-lg-8 col-lg-offset-2">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/UwzCGbsg3fw" frameborder="0"
                            allowfullscreen></iframe>
                </p>
            </center>
        </div>
        <p>
            Центральная окружность Цветка Жизни и все остальные шесть окружностей имеют равные радиусы, при этом центры
            этих шести окружностей располагаются в вершинах правильного шестиугольника, который вписан в 7ю центральную
            окружность узора. Такой узор является семеричным, а данную часть Цветка называют «Семя Жизни».
            К «Семени Жизни» добавляют еще 12 окружностей, центры которых являются вершинами вписанного шестиугольника.
            Таким образом, Цветок Жизни имеет 19 вершин, которые называют Верхними пределами.
        </p>
        <center>
            <p class="center">
                <img src="/images/site/logo/12002789_899213286823268_6206946398465518927_n.jpg"
                     class="thumbnail"
                     style="width: 100%; max-width: 400px;"
                    />
            </p>
        </center>
        <p>
            Символ Цветок Жизни содержит в себе самую важную структуру среди всех взаимосвязей в Сакральной Геометрии,
            называемую “Vesica Piscis” или рыбий пузырь. Данная конфигурация представляет собой площадь, ограниченную
            пересекающимися дугами кругов, при этом, центры двух кругов с равными радиусами расположены на окружностях
            друг друга. На основе Vesica Piscis получается равносторонний треугольник – один из самых ранних известных
            для человечества мистических символов. Vesica Piscis, возникающий при пересечении двух окружностей, является
            мистическим символом пересечения мира Духа и мира Материи – начало творения.
        </p>

        <p>
            «Цветок Жизни» - это эзотерическая информация, идущая через века, о том, как осознанно применять принципы
            Сакральной Геометрии для духовного роста человека.
        </p>
        <center>
            <p class="center">
                <img src="/images/site/logo/12031477_902118623207286_2987198916923122159_o.jpg"
                     class="thumbnail"
                     style="width: 100%; max-width: 600px;"
                    />
            </p>
        </center>

        <hr>

        <?= $this->render('../blocks/share', [
            'image'       => \yii\helpers\Url::to('/images/site/logo/ico.jpg', true) ,
            'url'         => \yii\helpers\Url::current([], true),
            'title'       => $this->title,
            'description' => '«Цветок Жизни» - знак, символ, изображение, которое отображает математический символ бесконечности ∞.
        Символ, «Цветок жизни», так же известен как суфийский лотос.',
        ]) ?>
    </div>
</div>