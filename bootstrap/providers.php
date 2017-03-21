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
use Groovey\Config\Providers\ConfigServiceProvider;
use Groovey\ORM\Providers\ORMServiceProvider;
use Groovey\Menu\Providers\MenuServiceProvider;
use Groovey\Breadcrumb\Providers\BreadcrumbServiceProvider;
use Groovey\Framework\Providers\Dumper as DumperServiceProvider;

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
        'dumper.show' => $app['config']->get('app.debug'),
    ]);

$app->register(new MonologServiceProvider(), [
        'monolog.name'    => 'app',
        'monolog.logfile' => APP_PATH.'/storage/logs/'.date('Y-m-d').'.log',
    ]);

$app->register(new TwigServiceProvider(), [
        'twig.path' => [
                APP_PATH.'/resources/templates',
                FRAMEWORK_PATH.'/resources/templates',
                FRAMEWORK_PATH.'/resources/templates/errors',
            ],
    ]);

$app->register(new MenuServiceProvider(), [
        'menu.config'    => APP_PATH.'/resources/yaml/menu.yml',
        'menu.templates' => FRAMEWORK_PATH.'/resources/templates/menus',
        'menu.cache'     => APP_PATH.'/storage/cache',
    ]);

$app->register(new BreadcrumbServiceProvider(), [
        'breadcrumb.path'  => FRAMEWORK_PATH.'/resources/templates/breadcrumbs',
        'breadcrumb.cache' => APP_PATH.'/storage/cache',
    ]);

return $app;
