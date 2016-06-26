<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\VarDumperServiceProvider;

use Groovey\Config\Providers\Config as ConfigServiceProvider;
use Groovey\Framework\Providers\Dumper as DumperServiceProvider;
// use Groovey\Framework\Providers\Mysql as MysqlServiceProvider;


$app->register(new SessionServiceProvider());
$app->register(new SerializerServiceProvider());
$app->register(new SwiftmailerServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new VarDumperServiceProvider());

$app->register(new ConfigServiceProvider(), [
        'config.path'        => APP_PATH.'/config',
        'config.environment' => ENVIRONMENT,
    ]);

$app->register(new DumperServiceProvider(), [
        'dumper.show' => $app->config('app.debug'),
    ]);

$app->register(new MonologServiceProvider(), [
        'monolog.name'    => 'app',
        'monolog.logfile' => APP_PATH.'/storage/logs/'.date('Y-m-d').'.log',
    ]);

$app->register(new TwigServiceProvider(), [
        'twig.path' => [
                APP_PATH.'/resources/templates',
                APP_PATH.'/vendor/groovey/framework/resources/templates',
                APP_PATH.'/vendor/groovey/framework/resources/templates/errors',
            ],
    ]);

// $app->register(new MysqlServiceProvider(), [
//         'mysql.connections' => $app->config('database.mysql'),
//     ]);

// if ($app->config('app.profiler')) {
//     $app->register(new WebProfilerServiceProvider(), [
//             'profiler.cache_dir'    => APP_PATH.'/storage/profiler/',
//             'profiler.mount_prefix' => '/_profiler',
//         ]);
// }



$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'groovey',
            'user'      => 'root',
            'password'  => 'webdevel',
            'charset'   => 'utf8mb4',
        ),
    ));

return $app;
