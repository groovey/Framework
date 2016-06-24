<?php

namespace Groovey\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Symfony\Component\Finder\Finder;
use Illuminate\Config\Repository;


class Config implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['config'] = function($app) {

            $path = $app['config.path'];
            $env  = $app['config.environment'];

            $folder = $path . '/' . strtolower($env);

            $phpFiles = Finder::create()->files()->name('*.php')->in($folder)->depth(0);

            foreach ($phpFiles as $file) {
                $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
            }

            $app->debug($files);

            $test = ['app' => require '/usr/share/nginx/html/Groovey/config/localhost/app.php'];

            return new Repository($test);
            };
    }

    public function boot(Application $app)
    {
    }


}
