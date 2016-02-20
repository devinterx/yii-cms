<?php

return [
    '/' => 'dashboard/dashboard',
    'login' => 'security/login',
    'signup' => 'security/register',
    'logout' => 'security/logout',

    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
];