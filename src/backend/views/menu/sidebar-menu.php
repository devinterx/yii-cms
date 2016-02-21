<?php
use backend\widgets\LTEMenu;

echo LTEMenu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            [
                'label' => Yii::t('app', 'Dashboard'),
                'url' => Yii::$app->homeUrl,
                'icon' => 'fa-dashboard',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl,
                'visible' => (
                    Yii::$app->user->can('BViewUsers')
                ),
            ],
            [
                'label' => Yii::t('app', 'FOR ADMINISTRATOR'),
                'options' => [
                    'class' => 'header',
                ],
                'visible' => (
                    Yii::$app->user->can('BViewUsers') ||
                    Yii::$app->user->can('BViewAssignments') ||
                    Yii::$app->user->can('BViewRoles') ||
                    Yii::$app->user->can('BViewPermissions') ||
                    Yii::$app->user->can('BViewRoutes') ||
                    Yii::$app->user->can('BViewRules')
                )
            ],
            [
                'label' => Yii::t('app', 'User Management'),
                'url' => ['#'],
                'icon' => 'fa fa-users',
                'options' => [
                    'class' => 'treeview',
                ],
                'active' => Yii::$app->request->url === Yii::$app->homeUrl,
                'visible' => Yii::$app->user->can('BViewUsers'),
                'items' => [
                    [
                        'label' => Yii::t('app', 'Users'),
                        'url' => ['user/index'],
                        'icon' => 'fa fa-user',
                        'visible' => Yii::$app->user->can('BViewUsers'),
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', 'User Permissions'),
                'url' => ['#'],
                'icon' => 'fa fa-lock',
                'options' => [
                    'class' => 'treeview',
                ],
                'active' => Yii::$app->request->url === Yii::$app->homeUrl,
                'visible' => (
                    Yii::$app->user->can('BViewAssignments') ||
                    Yii::$app->user->can('BViewRoles') ||
                    Yii::$app->user->can('BViewPermissions') ||
                    Yii::$app->user->can('BViewRoutes') ||
                    Yii::$app->user->can('BViewRules')
                ),
                'items' => [
                    [
                        'label' => Yii::t('app', 'Assignments'),
                        'url' => ['assignment/index'],
                        'icon' => 'fa fa-key',
                        //'visible' => (Yii::$app->user->identity->username == 'admin'),
                        'visible' => Yii::$app->user->can('BViewAssignments'),
                    ],
                    [
                        'label' => Yii::t('app', 'Roles'),
                        'url' => ['role/index'],
                        'icon' => 'fa fa-key',
                        'visible' => Yii::$app->user->can('BViewRoles'),
                    ],
                    [
                        'label' => Yii::t('app', 'Permissions'),
                        'url' => ['permission/index'],
                        'icon' => 'fa fa-key',
                        'visible' => Yii::$app->user->can('BViewPermissions'),
                    ],
                    [
                        'label' => Yii::t('app', 'Rules'),
                        'url' => ['rule/index'],
                        'icon' => 'fa fa-key',
                        'visible' => Yii::$app->user->can('BViewRules'),
                    ],
                    [
                        'label' => Yii::t('app', 'Routes'),
                        'url' => ['route/index'],
                        'icon' => 'fa fa-key',
                        'visible' => Yii::$app->user->can('BViewRoutes'),
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', 'MAIN MENU'),
                'options' => [
                    'class' => 'header',
                ]
            ]
        ]
    ]
);
