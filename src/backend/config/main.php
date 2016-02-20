<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Yii2-CMS ACP',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'dashboard/dashboard',
    'bootstrap' => ['log'],
    'language' => 'en-US',
    'modules' => [
        'gridview' =>  [
            'class' => \kartik\grid\Module::class
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => common\models\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['security/login'],
        ],
        'i18n' => [
            'translations' => [
                'acp*' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'security/error',
        ],
        'urlManager' => [
            'class' => yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/acp',
            'rules' => require_once(__DIR__ . '/routes.php')
        ],
        'request' => [
            'baseUrl' => '/acp'
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
