<?php

namespace Groovey\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;

class User extends Model
{
    public static function getContraints()
    {
        $constraint = new Assert\Collection([
            'name' => new Assert\NotBlank(),
            'password' => new Assert\NotBlank(),
        ]);

        return $constraint;
    }

    public static function add(array $data)
    {
        extract($data);

        $user           = new self();
        $user->name     = $name;
        $user->password = $password;

        $user->save();

        return $user->id;
    }
}
