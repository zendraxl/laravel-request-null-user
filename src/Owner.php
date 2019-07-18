<?php

namespace Zendraxl\LaravelRequestNullUser;

use Illuminate\Support\Traits\Macroable;

class Owner
{
    use Macroable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function __call($name, $arguments)
    {
        return $this->user->{$name}($arguments);
    }

    public function __get($name)
    {
        return $this->user->{$name} ?? null;
    }

    public function __set($name, $value)
    {
        $this->user->{$name} = $value;
    }

    public function isGuest(): bool
    {
        return $this->{NullUser::defaultProperty()} === NullUser::defaultType();
    }
}
