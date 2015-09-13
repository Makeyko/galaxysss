<?php
$this->title = 'Новая Земля 4D';
?>
<div class="container">
    <div class="col-lg-12">

        <h1 class="page-header"><?= \yii\helpers\Html::encode($this->title) ?></h1>

        <p class="lead">Земля Любви, Счастья, Изобилия и Прощения</p>

        <p><img src="/images/new_earth/index/header.jpg" width="100%" class="thumbnail"></p>
    </div>

    <div class="col-lg-12">
        <h2 class="page-header">Измерение 4D</h2>

        <p>Всем знакомо сокращение 3D, означающее «трёхмерный» (буква D — от слова dimension — измерение). Например,
            выбирая в кинотеатре фильм с пометкой 3D, мы точно знаем: для просмотра придётся надеть специальные очки, но
            зато картинка будет не плоской, а объёмной. А что такое 4D? Существует ли «четырёхмерное пространство» в
            реальности? И можно ли выйти в «четвёртое измерение»?</p>
    </div>
    <div class="col-lg-12">
        <p class="col-lg-6 col-lg-offset-3">
            <iframe class="thumbnail" width="100%" height="315" src="https://www.youtube.com/embed/fouyIFZt2y0"
                    frameborder="0" allowfullscreen></iframe>
        </p>
    </div>
    <div class="col-lg-12">

        <h2 class="page-header">Измерения жизни</h2>

        <div class="col-lg-4 col-lg-offset-2"><a href="#" type="button" data-toggle="modal" data-target="#myModal1"><img
                    class="thumbnail" src="/images/new_earth/index/i1.png"
                    style="width: 100%;max-width: 300px; max-height: 400px;"/></a></div>
        <div class="col-lg-4"><a href="#" type="button" data-toggle="modal" data-target="#myModal2"><img
                    class="thumbnail" src="/images/new_earth/index/i2.png"
                    style="width: 100%;max-width: 300px; max-height: 400px;"/></a></div>
    </div>

    <div class="col-lg-12">

        <h2 class="page-header">Процветание</h2>

        <p class="center-block" style="width: 100%;max-width: 600px; ">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/55AdvVbR-Fw" frameborder="0"
                    allowfullscreen></iframe>
        </p>
    </div>

    <hr class="col-lg-12">

    <div class="col-lg-12 row">
        <p> Смотрите также разделы:</p>

        <div class="list-group col-lg-4">
            <a href="<?= \yii\helpers\Url::to(['new_earth/declaration']) ?>" class="list-group-item">Декларация</a>
            <a href="<?= \yii\helpers\Url::to(['new_earth/manifest']) ?>" class="list-group-item">Манифест</a>
            <a href="<?= \yii\helpers\Url::to(['new_earth/codex']) ?>" class="list-group-item">Кодекс</a>
            <a href="<?= \yii\helpers\Url::to(['new_earth/residence']) ?>" class="list-group-item">Резиденция</a>
            <a href="<?= \yii\helpers\Url::to(['new_earth/hymn']) ?>" class="list-group-item">Гимн</a>
            <a href="<?= \yii\helpers\Url::to(['new_earth/history']) ?>" class="list-group-item">История
                Человечества</a>
        </div>
    </div>
    <div class="col-lg-12">
        <hr/>
    <?= $this->render('../blocks/share', [
        'image'       => \yii\helpers\Url::to('/images/new_earth/index/header.jpg', true),
        'url'         => \yii\helpers\Url::current([], true),
        'title'       => $this->title,
        'description' => 'Земля Любви, Счастья, Изобилия и Прощения',
    ]) ?>
    </div>

</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-body">
                <img class="text-center" src="/images/new_earth/index/i1.png" width="100%"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="width: 100%;">Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-body">
                <img class="text-center" src="/images/new_earth/index/i2.png" width="100%"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="width: 100%;">Закрыть
                </button>
            </div>
        </div>
    </div>
</div>