# Laravel Filterer
Easy Filtering for your Eloquent Models.
Have you been in the situation where you have a listing of a resource and you want to find those matching certain criteria? e.g. by date range, name, type, those same fields in a relation, etc.
Look no more, this package is for you.

## Installation
| Laravel Version  | Packagist Branch |
|---|---|
| 5.0.*  | `"adrianyg7/filterer": "1.0.*"`   |
| Later Laravel 5 versions  | `"adrianyg7/filterer": "1.1.*"` |

#### Install this package through Composer.
```shell
composer require adrianyg7/filterer
```

#### Register the following Service Provider
```php
// config/app.php

'providers' => [
    Adrianyg7\Filterer\FiltererServiceProvider::class,
];
```

## Usage
First, create a Filterer using the following artisan command.
```shell
php artisan make:filterer UserFilterer
```
This will create the file `app/Filterers/UserFilterer.php`.

Note: for more information about this command. `php artisan -h make:filterer`
```php
<?php

namespace App\Filterers;

use Adrianyg7\Filterer\Filterer;

class UserFilterer extends Filterer
{
    /**
     * The Model class to use.
     *
     * @var string
     */
    public $model = 'App\User';

    /**
     * Apply the appropriate filters.
     *
     * @return void
     */
    public function filters()
    {
        //
    }
}
```
Now, lets say we want all users containing the string `gmail` in their email column.
```php
// app/Filterers/UserFilterer.php

public function filters()
{
    $this->like('email');
}
```
```php
// app/Http/routes.php

Route::get('users', function (App\Filterers\UserFilterer $filterer) {
    return $filterer->results();
});
```
Finally, make the request `/users?email=gmail`.

By default, your results will be paginated. If you want to disable this feature, you can set the `$paginate` property of your Filterer to `false`.
```php
public $paginate = false;
```

To eager load relations to your results, set the `$with` property of your Filterer accordingly.
```php
public $with = [
    'roles',
];
```

#### Blade
Filterer implements the `IteratorAggregate` interface; that means, for example, that you can iterate it in your views.
```php
@foreach ($filterer as $user)
    // 
@endforeach
```

## Built-in methods
#### In Model
- like
- equal
- notEqual
- gt
- gte
- lt
- lte

The first argument for these methods is the column in which you are going to filter.
The second one is the request input key, if you don't provide it, the value of column will be assumed.
```php
// /users?correo_electronico=juan

$this->like('email', 'correo_electronico');
```

#### Relational
- relationLike
- relationEqual
- relationNotEqual
- relationGt
- relationGte
- relationLt
- relationLte

Almost the same as In Model methods, but another argument will be prepended, it is the name of the relation.
```php
// /users?role_name=admin

$this->relationLike('roles', 'name', 'role_name');
```

To add an `or` filter you can pass `$boolean = 'or'` to the last argument or use the dynamic methods provided by Filterer.
```php
// /users?q=foo

$this->like('first_name', 'q')
     ->like('last_name', 'q', 'or')
     ->relationLike('roles', 'name', 'q', 'or');

// or

$this->like('first_name', 'q')
     ->orLike('last_name', 'q')
     ->orRelationLike('roles', 'name', 'q');
```
The previous filters mean `find users that contain 'foo' in their first name, last name or role name`.

## Advance usage
To write your own filters, create a method as following.

```php
/**
 * Performs a where like clause to Builder.
 *
 * @param  string       $column
 * @param  string|null  $input
 * @param  string       $boolean
 * @return $this
 */
public function like($column, $input = null, $boolean = 'and')
{
    $input = $input ?: $column;

    if ($this->requestHas($input)) {
        $this->builder->where($column, 'like', "%{$this->input($input)}%", $boolean);
    }

    return $this;
}
```

Or code your logic directly in `filters` method.
```php
if ($this->requestHas('email')) {
    $this->builder->where('email', 'like', "%{$this->input('email')}%");
}
```

## Laravel 5.0 
This version has a bug that messes up your paginator when using `selectRaw` with bindings, in this case, use the `additionalColumns` method and the Filterer will build a functional paginator for you.
```php
public function additionalColumns()
{
    $this->builder->select('*')->selectRaw('? as greeting', ['hello']);
}
```
For later Laravel 5 versions, use the `1.1.*` packagist branch, which doesn't include this logic, since the bug was fixed.

## To Do
- Tests

## License
[Mit license](https://github.com/adrianyg7/filterer/blob/master/LICENSE)
