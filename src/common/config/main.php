<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => yii\caching\DummyCache::class,
        ],
        'authManager' => [
            'class' => common\components\DbManager::class,
            'cache' => 'cache',
            'defaultRoles' => ['user']
        ],
    ],
];
