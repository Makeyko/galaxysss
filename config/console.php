<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'aliases'          => [
        '@web'    => __DIR__ . '/../public_html/',
        '@csRoot' => __DIR__ . '/../app',
        '@upload' => __DIR__ . '/../public_html/upload',
    ],
    'modules'             => [
        'gii' => 'yii\gii\Module',
    ],
    'components'          => [
        'mailer' => require(__DIR__ . '/mailerTransport.php'),
        'cache'  => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'    => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'      => 'yii\log\DbTarget',
                    'categories' => ['gs\\*'],
                ],
            ],
        ],
        'urlManager'           => [
            'hostInfo'             => 'http://www.galaxysss.ru' ,
            'baseUrl'             => '',
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'suffix'              => '',
            'rules'               => require(__DIR__ . '/urlRules.php'),
        ],
        'db'     => $db,
    ],
    'params'              => $params,
];
