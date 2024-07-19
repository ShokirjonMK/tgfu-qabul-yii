<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Tashkent',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '6686082454:AAHePqzPHAzvR5NMtpY6BfuwMnM3Cw9HKyI',
        ],
//        'amocrm' => [
//            'class' => 'yii\amocrm\Client',
//            'subdomain' => 'example',
//            'login' => 'login@mail.com',
//            'hash' => '00000000000000000000000000000000',
//            'fields' => [
//                'StatusId' => 10525225,
//                'ResponsibleUserId' => 697344,
//            ],
//        ],
    ],
];
