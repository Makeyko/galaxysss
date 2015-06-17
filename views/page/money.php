<?php
$this->title = 'Деньги';
?>
<div class="container">

    <div class="page-header">
        <h1>Деньги</h1>
    </div>
    <p class="lead">Деньги – эквивалент вашей духовной силы и способности пропускать через себя большие потоки
        энергии.</p>

    <p><img src="/images/page/money/laxmi.jpg" width="100%" class="thumbnail"></p>


    <div class="row">
        <div class="col-lg-4 unityItem">
            <div class="header">

                <h2>Стратегия эволюции</h2>

            </div>

            <p><img src="/images/page/money/CRhgPTeT8V8.jpg" width="100%" class="thumbnail"></p>

            <p>
                Внедрение единой мировой валюты Благодарность. То есть стоимость товаров и услуг будет исчисляться в количестве благодарности
                которую необходимо заплатить, чтобы получить данный товар и услугу и не остаться при этом кармическим должником.
                Переход от "Благодарности" к "Любви". То есть безвозмездное оказание услуг и товаров.
                Таким образом достигается совершенное изобилие. То етсть человек получает товар или услугу по его заслуге.
            </p>
        </div>
        <?= \app\services\GsssHtml::unionCategoryItems(6) ?>

    </div>
    <?php if (count($articleList) > 0) { ?>
        <div class="row">
            <div class="page-header">
                <h2>Статьи</h2>
            </div>
            <div class="row">
                <?php foreach ($articleList as $item) {
                    echo \app\services\GsssHtml::articleItem($item, 'money');
                } ?>
            </div>
        </div>
    <?php } ?>
</div>