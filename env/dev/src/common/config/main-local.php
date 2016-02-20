<?php
return [
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2-cms',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
        'fs' => [
            'class' => creocoder\flysystem\LocalFilesystem::class,
            'path' => '@root/data',
        ],
    ],
];
