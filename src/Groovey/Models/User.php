<?php

namespace Groovey\Framework\Models;

use Pimple\Container;

class User
{

    public function __construct(Container $app)
    {
        $this->app = $app;
    }
    public function test(){

        $app = $this->app;

    }

    // public static function add(array $data)
    // {
    //     extract($data);

    //     $user           = new self();
    //     $user->name     = $name;
    //     $user->password = $password;

    //     $user->save();

    //     return $user->id;
    // }
}
