<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'dashboard/dashboard',
    'modules' => [
        'gridview' => [
            'class' => \kartik\grid\Module::class
        ]
    ],
    'components' => [
        'urlManager' => [
            'class' => yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/acp',
            'rules' => require_once(__DIR__ . '/routes.php')
        ],
        'assetManager' => [
            'class' => yii\web\AssetManager::class,
            'linkAssets' => true,
            'baseUrl' => '/assets',
            'appendTimestamp' => true,
        ],
        'reCaptcha' => [
            'class' => himiklab\yii2\recaptcha\ReCaptcha::class,
            'name' => 'reCaptcha',
            'siteKey' => '6Lc0jAMTAAAAADCY9dfAJuCiQnLTQCePKPQ06vi0',
            'secret' => '6Lc0jAMTAAAAAD3b-RGtc4CnVEUcmWRmRdQZvzjo',
        ],
    ],
    'params' => $params,
];
