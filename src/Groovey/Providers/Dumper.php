<?php

namespace Groovey\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Dumper implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['dumper'] = $app->protect(function ($app) {
            return new VarDumper();
        });
    }

    public function boot(Application $app)
    {
        // VarDumper::setHandler(function ($var) {

        //     $cloner = new VarCloner();
        //     $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

        //     $dumper->dump($cloner->cloneVar($var));
        // });
    }
}
