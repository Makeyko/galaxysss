<?php

/** @var array $articleList */

use yii\helpers\Url;


$this->title = 'Арийское Время';
?>
<div class="container">

    <div class="col-lg-12">
        <h1 class="page-header">Арийское время</h1>

        <p>
            <object
                classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
                codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
                height="700"
                width="225">
                <param name="allowFullScreen" value="true">
                <param name="quality" value="high">
                <param name="movie" value="/js/SlavClockFull_alt.swf">
                <embed
                    allowfullscreen="true"
                    height="700"
                    pluginspage="http://www.macromedia.com/go/getflashplayer"
                    quality="high"
                    src="/js/SlavClockFull_alt.swf"
                    type="application/x-shockwave-flash"
                    width="225"
                    >
            </object>
        </p>

        <hr>
        <?= $this->render('../blocks/share', [
            'image'       => Url::to('/images/page/time/2.jpg', true),
            'url'         => Url::current([], true),
            'title'       => $this->title,
            'description' => 'Когда время согласовано с ритмами природы, тогда мы можем мыслить в масштабах Вечности.',
        ]) ?>
    </div>

</div>
