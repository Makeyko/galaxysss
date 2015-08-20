<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'               => 'basic',
    'basePath'         => dirname(__DIR__),
    'bootstrap'        => ['log'],
    'language'         => 'ru',
    'aliases'          => [
        '@web'    => __DIR__ . '/public_html/',
        '@csRoot' => __DIR__ . '/../app',
        '@upload' => __DIR__ . '/public_html/upload',
    ],
    'components'       => [
        'assetManager'         => [
            'appendTimestamp' => true,
        ],
        'request'              => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey'    => '',
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
        ],
        'cache' =>
            (YII_ENV_PROD) ?
                [
                    'class'   => 'yii\caching\MemCache',
                    'servers' => [
                        [
                            'host' => 'localhost',
                            'port' => 11211,
                        ],
                    ],
                ] :
                [
                    'class' => 'yii\caching\FileCache',
                ],
        'deviceDetect'         => [
            'class'     => 'app\services\DeviceDetect',
            'setParams' => 'false',
        ],
        'user'                 => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'        => ['auth/login'],
        ],
        'errorHandler'         => [
            'errorAction' => 'site/error',
        ],
        'urlManager'           => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'suffix'              => '',
            'rules'               => require(__DIR__ . '/urlRules.php'),
        ],
        'mailer'               => require(__DIR__ . '/mailerTransport.php'),
        'log'                  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                    ],
                    'maxLogFiles' => 1,
                ],
                [
                    'class'  => 'yii\log\DbTarget',
                    'categories' => ['gs\\*'],
                ],
                [
                    'class'      => 'yii\log\EmailTarget',
                    'levels'     => [
                        'error',
                        'warning',
                    ],
                    'categories' => ['yii\db\*'],
                    'message'    => [
                        'from'    => ['admin@galaxysss.ru'],
                        'to'      => ['god@galaxysss.ru'],
                        'subject' => 'GALAXYSSS.RU ERROR',
                    ],
                ],
            ],
        ],
        'db'                   => require(__DIR__ . '/db.php'),
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => require(__DIR__ . '/authClientCollection.php'),
        ],
        'formatter'            => [
            'dateFormat'        => 'dd.MM.yyyy',
            'timeFormat'        => 'php:H:i:s',
            'datetimeFormat'    => 'php:d.m.Y H:i',
            'decimalSeparator'  => '.',
            'thousandSeparator' => ' ',
            'currencyCode'      => 'RUB',
            'locale'            => 'ru-RU',
            'nullDisplay'       => '',
        ],
        'view'                 => [
            'renderers' => [
                'tpl' => [
                    'class'     => 'yii\smarty\ViewRenderer',
                    'cachePath' => '@runtime/Smarty/cache',
                    'widgets'   => [
                        'blocks' => [
                            'ActiveForm' => 'yii\widgets\ActiveForm',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'params'           => $params,
    'controllerMap'    => [
        'upload'       => 'cs\Widget\FileUploadMany\UploadController',
        'comment'      => 'app\modules\Comment\Controller',
        'html_content' => 'cs\Widget\HtmlContent\Controller',
    ],
    'on ' . \yii\base\Application::EVENT_BEFORE_REQUEST => function ($event) {
        \Yii::$app->session->remove(\app\services\SiteUpdateItemsCounter::SESSION_KEY);
        if (!\Yii::$app->user->isGuest) {
            \app\services\SiteUpdateItemsCounter::calc();
            \app\services\UserLastActive::update();
        }
    }
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
