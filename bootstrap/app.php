<?php

use Silex\Application;

class App extends Application
{
    use Silex\Application\MonologTrait;
    use Silex\Application\TwigTrait;
    use Silex\Application\UrlGeneratorTrait;
    use Groovey\Traits\Config;
    use Groovey\Traits\Translation;
    use Groovey\Traits\Dumper;
}

$app = new App();

return $app;
