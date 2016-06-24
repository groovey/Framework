<?php

namespace Groovey\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository;

class Config implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['config'] = $app->protect(function($test) use ($app) {

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
