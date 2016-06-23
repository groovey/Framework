<?php

namespace Groovey\Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Dumper implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['dumper'] = $app->share(function ($app) {
            return new VarDumper();
        });
    }

    public function boot(Application $app)
    {
        VarDumper::setHandler(function ($var) {

            $cloner = new VarCloner();
            $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

            $dumper->dump($cloner->cloneVar($var));
        });
    }
}
