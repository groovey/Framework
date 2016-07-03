<?php

namespace Groovey\Framework\Models;

use Groovey\ORM\Model;

class User extends Model
{
    public function __construct($app)
    {
        $this->app = $app;
    }
}
