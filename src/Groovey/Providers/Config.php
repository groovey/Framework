<?php

namespace Groovey\Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository;

class Config implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['config'] = $app->share(function ($app) {

                $path = $app['config.path'];
                $env  = $app['config.environment'];

                $filesystem = new Filesystem();
                $loader     = new FileLoader($filesystem, $path);

                return new Repository($loader, $env);
            });
    }

    public function boot(Application $app)
    {
    }
}
