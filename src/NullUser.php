<?php

namespace Zendraxl\LaravelRequestNullUser;

class NullUser
{
    protected const DEFAULT_EMAIL = 'guest@example.com';
    protected const DEFAULT_NAME = 'Guest';
    protected const DEFAULT_TYPE = 'guest';

    public $email;
    public $name;
    public $type;

    public function __construct()
    {
        $this->setDefaults();
    }

    public static function defaultEmail(): string
    {
        return env('ZENDRAXL_NULL_USER_EMAIL') ?: static::DEFAULT_EMAIL;
    }

    public static function defaultName(): string
    {
        return env('ZENDRAXL_NULL_USER_NAME') ?: static::DEFAULT_NAME;
    }

    public static function defaultType(): string
    {
        return env('ZENDRAXL_NULL_USER_TYPE') ?: static::DEFAULT_TYPE;
    }

    protected function setDefaults(): void
    {
        $this->email = static::defaultEmail();
        $this->name = static::defaultName();
        $this->type = static::defaultType();
    }
}
