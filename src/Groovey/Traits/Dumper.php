<?php

namespace Groovey\Traits;

trait Dumper
{
    public function debug($message, $option = '')
    {
        // if (!$this['config']->get('app.debug')) {
        //     return;
        // }
        return print dump($message);
    }
}
