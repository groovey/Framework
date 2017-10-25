<?php


$path = FRAMEWORK_PATH.'/resources/generators';

$app['generator.config'] = [

    'Controller' => [
        'source' => $path.'/controller.php',
        'destination' => APP_PATH.'/app/controllers/ARG1.php',
        'replace' => [
            'class'    => 'ARG1|ucfirst',
            'comments' => 'Code goes here.',
        ],
    ],
];
