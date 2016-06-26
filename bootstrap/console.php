<?php

use Symfony\Component\Console\Application;
use Groovey\Migration\Adapters\Adapter;
use Groovey\Migration\Adapters\Mysql;
use Groovey\Migration\Migration;

$console = new Application($app['config']->get('app.name'), '1.0.0');
$console->setDispatcher($app['dispatcher']);

$console->addCommands([

            // Migrations
            new Groovey\Migration\Commands\About(),
            new Groovey\Migration\Commands\Init($app),
            new Groovey\Migration\Commands\Reset($app),
            new Groovey\Migration\Commands\Listing($app),
            new Groovey\Migration\Commands\Status($app),
            new Groovey\Migration\Commands\Create($app),
            new Groovey\Migration\Commands\Up($app),
            new Groovey\Migration\Commands\Down($app),



        ]);

return $console;
