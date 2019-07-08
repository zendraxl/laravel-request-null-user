<?php

namespace Zendraxl\LaravelRequestNullUser;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class NullUserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Request::macro('owner', function (): Owner {
            $user = $this->user() ?? new NullUser;
            return new Owner($user);
        });
    }
}
