<?php

use Silex\Application;

class App extends Application
{
    use Silex\Application\MonologTrait;
    use Silex\Application\TwigTrait;
    use Silex\Application\UrlGeneratorTrait;
    use Groovey\Framework\Traits\Dumper;
}

$app = new App();

return $app;
