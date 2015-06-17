<?php

if (YII_ENV == 'prod') {
    return [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets'    => [
            [
                'class'  => 'yii\log\DbTarget',
                'categories' => ['cs\*'],
            ],
            [
                'class'      => 'yii\log\EmailTarget',
                'levels'     => ['error'],
                'categories' => ['yii\db\*'],
                'message'    => [
                    'from'    => ['log@example.com'],
                    'to'      => ['dram1008@yandex.ru'],
                    'subject' => 'Database errors at client.cs',
                ],
            ],
        ],
    ];
}
else {
    return [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets'    => [
            [
                'class' => 'yii\log\FileTarget',
            ],
            [
                'class'  => 'yii\log\DbTarget',
                'categories' => ['cs\*'],
//                'levels'     => ['error','info','trace'],
            ],
            [
                'class'      => 'yii\log\EmailTarget',
                'levels'     => ['error'],
                'categories' => ['yii\db\*'],
                'message'    => [
                    'from'    => ['log@example.com'],
                    'to'      => ['dram1008@yandex.ru'],
                    'subject' => 'Database errors at client.cs',
                ],
            ],
        ],
    ];
}
