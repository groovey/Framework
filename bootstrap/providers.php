<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\FormServiceProvider;
use Whoops\Provider\Silex\WhoopsServiceProvider;
use EmanueleMinotto\FakerServiceProvider\FakerServiceProvider;
use Groovey\Providers\Config as ConfigServiceProvider;
use Groovey\Providers\Mysql as MysqlServiceProvider;
use Groovey\Providers\Dumper as DumperServiceProvider;

$app->register(new SessionServiceProvider());
$app->register(new SerializerServiceProvider());
$app->register(new SwiftmailerServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());

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

$app->register(new FakerServiceProvider(), [
        'locale' => 'en_US',
    ]);

$app->register(new MysqlServiceProvider(), [
        'mysql.connections' => $app->config('database.mysql'),
    ]);

if ($app->config('app.profiler')) {
    $app->register(new WebProfilerServiceProvider(), [
            'profiler.cache_dir'    => APP_PATH.'/storage/profiler/',
            'profiler.mount_prefix' => '/_profiler',
        ]);
}

if ($app->config('app.debug') && $app->config('app.whoops')) {
    $app->register(new WhoopsServiceProvider());
}

return $app;
