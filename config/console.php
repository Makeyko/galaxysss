<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'mailer'               => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport'        => require(__DIR__ . '/mailerTransport.php'),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'  => 'yii\log\DbTarget',
                    'categories' => ['gs\\*'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
