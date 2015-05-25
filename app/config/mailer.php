<?php

return (YII_ENV == 'prod') ? // production
    [
        'class'            => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => false,
        'transport'        => [
            'class' => 'Swift_SmtpTransport',
            'host'  => 'suffra.com',
            'port'  => '25',
        ],
    ] : // development
    [
        'class'            => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => false,
        'transport'        => [
            'class'      => 'Swift_SmtpTransport',
            'host'       => 'smtp.gmail.com',
            'port'       => '465',
            'username'   => 'solncelub@gmail.com',
            'password'   => 'solncelub1',
            'encryption' => 'ssl',
        ],
    ];
