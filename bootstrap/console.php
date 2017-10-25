<?php

use Symfony\Component\Console\Application;

$console = new Application($app['config']->get('app.name'), '1.0.0');
$console->setDispatcher($app['dispatcher']);

$console->addCommands([
            new Groovey\Migration\Commands\Init($app),
            new Groovey\Migration\Commands\Listing($app),
            new Groovey\Migration\Commands\Status($app),
            new Groovey\Migration\Commands\Create($app),
            new Groovey\Migration\Commands\Up($app),
            new Groovey\Migration\Commands\Down($app),
            new Groovey\Seeder\Commands\Init($app),
            new Groovey\Seeder\Commands\Create($app),
            new Groovey\Seeder\Commands\Run($app),
            new Groovey\Seeder\Commands\Run($app),
            new Groovey\Generator\Commands\Create($app),
            new Groovey\Framework\Commands\About($app),
            new Groovey\Framework\Commands\DB($app),
      ]);

return $console;
