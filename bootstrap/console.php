<?php

use Symfony\Component\Console\Application;
use Groovey\Migration\Adapters\Adapter;
use Groovey\Migration\Adapters\Mysql;
use Groovey\Migration\Migration;



$console = new Application('Groovey', '1.0.0');
$console->setDispatcher($app['dispatcher']);


// $adapter   = new Adapter(new Mysql());
// $migration = new Migration($adapter);



// $commands = array_merge(
//                     $migration->getCommands()

//                 );


// $console->addCommands($commands);

return $console;
