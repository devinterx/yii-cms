<?php
use yii\bootstrap\Nav;

$menuItemsMain = [
    [
        'label' => '<i class="fa fa-cog"></i> ' . Yii::t('app', 'Site CMS'),
        'url' => ['#'],
        'active' => false,
        'items' => [
            [
                'label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'Catalog'),
                'url' => '#',
            ],
            [
                'label' => '<i class="fa fa-user-md"></i> ' . Yii::t('app', 'Posts'),
                'url' => '#',
            ],
        ],
    ],
];

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $menuItemsMain,
    'encodeLabels' => false,
]);
