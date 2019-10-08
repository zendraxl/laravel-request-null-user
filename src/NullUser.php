<?php

namespace Zendraxl\LaravelRequestNullUser;

class NullUser
{
    public $email;
    public $name;
    public $type;

    public function __construct()
    {
        $this->setDefaults();
    }

    public static function defaultEmail(): string
    {
        return env('ZENDRAXL_NULL_USER_EMAIL', config('usernull.DEFAULT_EMAIL'));
    }

    public static function defaultName(): string
    {
        return env('ZENDRAXL_NULL_USER_NAME', config('usernull.DEFAULT_NAME'));
    }

    public static function defaultProperty(): string
    {
        return env('ZENDRAXL_TYPE_PROPERTY', config('usernull.DEFAULT_PROPERTY'));
    }

    public static function defaultType(): string
    {
        return env('ZENDRAXL_NULL_USER_TYPE', config('usernull.DEFAULT_TYPE'));
    }

    protected function setDefaults(): void
    {
        $this->email = static::defaultEmail();
        $this->name = static::defaultName();
        $this->{static::defaultProperty()} = static::defaultType();
    }
}
