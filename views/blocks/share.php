<?php

/** @var $url */
/** @var $image */
/** @var $title */
/** @var $summary */
/** @var $description */

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use cs\services\Url as csUrl;

$this->registerMetaTag(['name' => 'og:image', 'content' => $image   ]);
$this->registerMetaTag(['name' => 'og:url', 'content' => $url   ]);
$this->registerMetaTag(['name' => 'og:title', 'content' => $title   ]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description   ]);

$this->registerJs("$('#share').popover()");

?>
<?= ButtonDropdown::widget([
    'label'    => 'Поделиться',
    'dropdown' => [
        'options' => ['class' => 'pull-top pull-center'],
        'items'   => [
            ['label'       => 'Facebook',
             'linkOptions' => ['target' => '_blank'],
             'url'         => (string)(new csUrl('http://www.facebook.com/sharer.php', [
                 'u'     => $url,
             ]))
            ],
            [
                'label'       => 'Vkontakte',
                'linkOptions' => ['target' => '_blank'],
                'url'         => (string)(new csUrl('http://vkontakte.ru/share.php', ['url' => $url]))
            ],
            [
                'label'       => 'Odnoklasniki',
                'linkOptions' => ['target' => '_blank'],
                'url'         => (string)(new csUrl('http://www.odnoklassniki.ru/dk', [
                        'st._surl' => $url,
                        'st.cmd'   => 'addShare',
                        'st.s'     => 1
                    ]))
            ],
            [
                'label'       => 'Google+',
                'linkOptions' => ['target' => '_blank'],
                'url'         => (string)(new csUrl('https://plus.google.com/share', ['url' => $url]))
            ],
            [
                'label'       => 'Twitter',
                'linkOptions' => ['target' => '_blank'],
                'url'         => (string)(new csUrl('http://twitter.com/share', [
                        'url'  => $url,
                        'text' => '11s'
                    ]))
            ],
        ],
    ],
]) ?>