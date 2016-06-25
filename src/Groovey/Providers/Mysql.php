<?php

namespace Groovey\Framework\Providers;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Cache\CacheManager;

class Mysql implements ServiceProviderInterface
{
    public function register(PimpleContainer $app)
    {
        $app['mysql.global']   = true;
        $app['mysql.eloquent'] = true;

        $app['mysql.default'] = [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => null,
                'username'  => 'root',
                'password'  => null,
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => null,
                'logging'   => false,
        ];

        $app['mysql.container'] = $app->protect(function () {
            return new Container();
        });

        $app['mysql.dispatcher'] = $app->protect(function () use ($app) {
            return new Dispatcher($app['mysql.container']);
        });

        if (class_exists('Illuminate\Cache\CacheManager')) {
            $app['mysql.cache_manager'] = $app->protect(function () use ($app) {
                return new CacheManager($app['mysql.container']);
            });
        }

        $app['mysql'] = $app->protect(function ($name) use ($app) {

            $capsule = new Capsule($app['mysql.container']);
            $capsule->setEventDispatcher($app['mysql.dispatcher']);

            if (isset($app['mysql.cache_manager']) && isset($app['mysql.cache'])) {
                $capsule->setCacheManager($app['mysql.cache_manager']);
                foreach ($app['mysql.cache'] as $key => $value) {
                    $app['mysql.container']->offsetGet('config')->offsetSet('cache.'.$key, $value);
                }
            }

            if ($app['mysql.global']) {
                $capsule->setAsGlobal();
            }

            if ($app['mysql.eloquent']) {
                $capsule->bootEloquent();
            }

            $this->setConnection($app, $capsule, 'write');
            $this->setConnection($app, $capsule, 'read');

            $this->setMultipleConnections($app, $capsule);

            return $capsule;
        });
    }

    private function setConnection(Application $app, Capsule $capsule, $name = 'default')
    {
        $servers = $app['mysql.connections'][$name];

        $connected = false;

        while (!$connected && count($servers)) {
            $key     = array_rand($servers);
            $server  = $servers[$key];
            $logging = $server['logging'];

            unset($server['logging']);

            $connectionName = ($name == 'write') ? 'default' : $name;

            $capsule->addConnection($server, $connectionName);

            if ($logging) {
                $capsule->connection($connectionName)->enableQueryLog();
            } else {
                $capsule->connection($connectionName)->disableQueryLog();
            }

            try {
                $capsule->getConnection($connectionName);
                $connected = true;
            } catch (\Exception $e) {
                unset($servers[$key]);
            }
        }
    }

    private function setMultipleConnections(Application $app, Capsule $capsule)
    {
        $servers = $app['mysql.connections'];
        unset($servers['write']);
        unset($servers['read']);

        foreach ($servers as $connection => $server) {
            $logging = $server['logging'];
            unset($server['logging']);

            $capsule->addConnection($server, $connection);

            if ($logging) {
                $capsule->connection($connection)->enableQueryLog();
            } else {
                $capsule->connection($connection)->disableQueryLog();
            }
        }
    }

    public function boot(Application $app)
    {
        if ($app['mysql.eloquent']) {
            $app->before(function () use ($app) {
                $app['mysql'];
            }, Application::EARLY_EVENT);
        }
    }
}
