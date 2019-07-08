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

    public function __get($name)
    {
        return $this->user->{$name} ?? null;
    }

    public function isGuest(): bool
    {
        return ($this->user->type ?? null) === NullUser::defaultType();
    }
}
