# Laravel Request Null User

Null Object Pattern for User fetched from Request for Laravel framework.

## Install

To install just run following command from terminal:

`composer require zendraxl/laravel-request-null-user`

## Usage

Since the `user()` method is already taken on `\Illuminate\Http\Request` object, this package provides `owner()` method cause it makes some sense that the person that made the request is the owner of that request.

You can use any of these:

- Dependency Injection Request object

```
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index(\Illuminate\Http\Request $request)
{
    $owner = $request->owner();
    // ...
}
```

- Laravel Facade Request object

```
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
	$owner = \Illuminate\Support\Facades\Request::owner();
	// ...
}
```

- Global `request()` function

```
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
	$owner = request()->owner();
	// ...
}
```

Object returned by the `owner()` method is an instance of `\Zendraxl\LaravelRequestNullUser\Owner`. It is a simple wrapper/decorator so `\App\User` class does not have to be modified.

What this is allowing for is, that it can somewhat guarantee the same `API` across both `\App\User` and `\Zendraxl\LaravelRequestNullUser\NullUser` objects without code duplication and respecting the DRY (Don't Repeat Yourself).

Only method defined on the `\Zendraxl\LaravelRequestNullUser\Owner` object is `isGuest()` method. This method will return `true` if the visitor is not authenticated, and `false` if the visitor is authenticated.

## Defaults

Out of the box `\Zendraxl\LaravelRequestNullUser\NullUser` comes with following public properties:

```
public $email = 'guest@example.com';
public $name = 'Guest';
public $type = 'guest';
```

All of them can be accessed directly through the `\Zendraxl\LaravelRequestNullUser\Owner` object:

```
echo $owner->email; // guest@example.com
echo $owner->name; // Guest
echo $owner->type; // guest
```

Each default can be changed by defining following env variables:

```
ZENDRAXL_NULL_USER_EMAIL=zendraxl@gmail.com
ZENDRAXL_NULL_USER_NAME=Drazen
ZENDRAXL_NULL_USER_TYPE=alien
```

## Extend

`\Zendraxl\LaravelRequestNullUser\Owner` object is extendable via `Macros` since it is using `Illuminate\Support\Traits\Macroable` trait.

Add `isAdmin()` method to `\Zendraxl\LaravelRequestNullUser\Owner`:

```
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Zendraxl\LaravelRequestNullUser\Owner;

class AppServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		Owner::macro('isAdmin', function () {
		    return $this->type === 'admin';
		});
	}
}
```

Additional `isType()` methods can be also added to the `\Zendraxl\LaravelRequestNullUser\Owner` object with env variable `ZENDRAXL_USER_TYPES`. By adding a comma separated list of types everything will be generated on the fly.

If the database has `admin`, `manager`, `supervisor`, `pro user`, `user` types on the `\App\User` model and this is added to the `.env` file:

```
ZENDRAXL_USER_TYPES=admin,manager,supervisor,pro user,user
```

then the following methods will be added to the `\Zendraxl\LaravelRequestNullUser\Owner` object:

```
$owner->isAdmin();
$owner->isManager();
$owner->isSupervisor();
$owner->isProUser();
$owner->isUser();
```