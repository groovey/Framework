<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Groovey\Config\Providers\ConfigServiceProvider;
use Groovey\Menu\Providers\MenuServiceProvider;
use Groovey\Breadcrumb\Providers\BreadcrumbServiceProvider;
use Groovey\Support\Providers\TraceServiceProvider;
use Groovey\Tester\Providers\TesterServiceProvider;
use Groovey\JWT\Providers\JWTServiceProvider;
use Groovey\Support\Providers\DateServiceProvider;
use Groovey\Support\Providers\HttpServiceProvider;
use Groovey\Security\Providers\SecurityServiceProvider;
use Groovey\SSO\Providers\SSOServiceProvider;
use Groovey\DB\Providers\DBServiceProvider;

$app->register(new SessionServiceProvider());
$app->register(new SerializerServiceProvider());
$app->register(new SwiftmailerServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TraceServiceProvider());
$app->register(new TesterServiceProvider());
$app->register(new DateServiceProvider());
$app->register(new HttpServiceProvider());
$app->register(new SecurityServiceProvider());

$app->register(new ConfigServiceProvider(), [
        'config.path'        => APP_PATH.'/config',
        'config.environment' => ENVIRONMENT,
    ]);

$app->register(new MonologServiceProvider(), [
        'monolog.name'    => 'app',
        'monolog.logfile' => APP_PATH.'/storage/logs/'.date('Y-m-d').'.log',
    ]);

$app->register(new JWTServiceProvider(), [
        'jwt.key' => $app['config']->get('app.jwt_key'),
    ]);

$app->register(new SSOServiceProvider(), [
        'sso.domain' => $app['config']->get('app.sso_url'),
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

$app->register(new DBServiceProvider(), [
        'db.connection' => [
            'host'      => 'localhost',
            'driver'    => 'mysql',
            'database'  => 'groovey',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'logging'   => true,
        ],
    ]);

return $app;
