<?php

use Symfony\Component\Console\Application;

$console = new Application('Groovey', '1.0.0');
$console->setDispatcher($app['dispatcher']);
$console->addCommands(array(
    new App\Console\Prototype($app),
));

return $console;
