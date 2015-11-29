<?php


return (strpos($_SERVER['SERVER_NAME'], 'galaxysss.com') !== false)? [
    'facebook'  => [
        'class'        => 'app\services\authclient\Facebook',
        'clientId'     => '727747647330665',
        'clientSecret' => '16021d4027546e58c4ad5341fe305739',
    ],
    'vkontakte' => [
        'class'        => 'app\services\authclient\VKontakte',
        'clientId'     => '5164777',
        'clientSecret' => '18vsMLYPhscYijuTWyqp',
    ],
] :  [
    'facebook'  => [
        'class'        => 'app\services\authclient\Facebook',
        'clientId'     => '1114239771926233',
        'clientSecret' => '51ae4b3deed4a2c8d35356069aff55ad',
    ],
    'vkontakte' => [
        'class'        => 'app\services\authclient\VKontakte',
        'clientId'     => '4896568',
        'clientSecret' => 'lQD6kk2VshQlxEaw27Pw',
    ],
//    'google'    => [
//        'class'        => 'yii\authclient\clients\GoogleOAuth',
//        'clientId'     => '1010330569803-90s01v0njq8vte2eortphm7mcsvni9af.apps.googleusercontent.com',
//        'clientSecret' => '5JUoqsqcMTBK7Wmvm8pbEL0w',
//    ],
];