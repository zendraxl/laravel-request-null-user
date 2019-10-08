<?php

namespace Zendraxl\LaravelRequestNullUser;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class NullUserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->addOwnerMethodToRequest();
        $this->addIsTypeMethodsToOwner();
        
        $this->publishes([
            package_path('config') => config_path()
        ]);
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(package_path('src/config/usernull.php'), 'usernull');
    }

    protected function addIsTypeMethodsToOwner(): void
    {
        collect(explode(',', env('ZENDRAXL_USER_TYPES')))
            ->each(function (string $type) {
                Owner::macro('is'.Str::studly($type), function () use ($type) {
                    return $this->{NullUser::defaultProperty()} === $type;
                });
            });
    }

    protected function addOwnerMethodToRequest(): void
    {
        Request::macro('owner', function (): Owner {
            $user = $this->user() ?? new NullUser;
            return new Owner($user);
        });
    }
}
