<?php

return [
    //'/' => 'dashboard/dashboard',
    'login' => 'backend/security/login',
    'signup' => 'backend/security/register',
    'logout' => 'backend/security/logout',

    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
];
