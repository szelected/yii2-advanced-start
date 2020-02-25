<?php

use yii\gii\Module as GiiModule;

return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => GiiModule::class
    ],
    'components' => [
        'urlManager' => [
            'baseUrl' => '/',
            'hostInfo' => $params['frontendUrl'],
        ],
    ]
];
