<?php

namespace Groovey\Traits;

trait Dumper
{
    public function debug($message, $option = '')
    {
        if (!$this['config']->get('app.debug')) {
            return;
        }

        return $this['dumper']::dump($message);
    }
}
