<?php

$main = (YII_ENV == 'prod') ? // production
    [
        'site'   => [
            'serverName' => 'credit.suffra.com',
        ],
        'client' => [
            'serverName' => 'ccredit.suffra.com',
        ],
        'bank'   => [
            'serverName' => 'bcredit.suffra.com',
        ],
        'admin'  => [
            'serverName' => 'acredit.suffra.com',
        ],
        'lombard'  => [
            'serverName' => 'lcredit.suffra.com',
        ],
    ] : // development
    [
        'site'   => [
            'serverName' => 'site.creditsystem',
        ],
        'client' => [
            'serverName' => 'client.creditsystem',
        ],
        'bank'   => [
            'serverName' => 'bank.creditsystem',
        ],
        'admin'  => [
            'serverName' => 'admin.creditsystem',
        ],
        'lombard'  => [
            'serverName' => 'lombard.creditsystem',
        ],
    ];

$main = \yii\helpers\ArrayHelper::merge([
    'version' => '1.0',
    'site'    => [
        'folder' => 'site',
    ],
    'client'  => [
        'folder' => 'client',
    ],
    'bank'    => [
        'folder' => 'bank',
    ],
    'admin'   => [
        'folder' => 'admin',
    ],
    'lombard'   => [
        'folder' => 'lombard',
    ],
], $main);

return $main;
