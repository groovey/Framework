<?php

use Symfony\Component\Console\Application;
use Groovey\Migration\Adapters\Adapter;
use Groovey\Migration\Adapters\Mysql;
use Groovey\Migration\Migration;



$console = new Application('Groovey', '1.0.0');
$console->setDispatcher($app['dispatcher']);




$console->addCommands([
            new Groovey\Migration\Commands\About(),
            new Groovey\Migration\Commands\Init($app),

        ]);

return $console;
