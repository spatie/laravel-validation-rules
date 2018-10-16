# A set of useful Laravel validation rules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-validation-rules.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-validation-rules)
[![Code coverage](https://scrutinizer-ci.com/g/spatie/laravel-validation-rules/badges/coverage.png)](https://scrutinizer-ci.com/g/spatie/laravel-validation-rules)
[![Build Status](https://img.shields.io/travis/spatie/laravel-validation-rules/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-validation-rules)
[![StyleCI](https://github.styleci.io/repos/152587206/shield?branch=master)](https://github.styleci.io/repos/152587206)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-validation-rules.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-validation-rules)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-validation-rules.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-validation-rules)

This repository contains some useful Laravel validation rules.


You can install the package via composer:

```bash
composer require spatie/laravel-validation-rules
```

The package will automatically register itself.


## Available rules

- [`authorized`](#authorized)
- [`enum`](#enum)
- [`modelsExist`](#modelids)
- [`futureDate`](#futuredate)
- [`pastDate`](#pastdate)
- [`dateBetween`](#date)

### `authorized`

Determine if the user is authorized to perform an ability on an instance of the given model. The id of the model is the field under validation 

Consider the following policy:

```php
class ModelPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Model $model): bool
    {
        return $model->user->id === $user->id;
    }
}
```

This validation rule will pass if the id of the logged in user matches the `user_id` on `TestModel` who's it is in the `model_id` key of the request.

```php
// in a `FormRequest`

public function rules()
{
    return [
        'model_id' => [new Authorized('edit', TestModel::class)],
    ];
}
```

### `enum`

This rule will validate if the value under validation is part of the given enum class. We assume that the enum class has a static `toArray` method that returns all valid values. If you're looking for a good enum class, take a look at [myclabs/php-enum](https://github.com/myclabs/php-enum);

Consider the following enum class:

```php
class UserRole extends MyCLabs\Enum\Enum
{
    const ADMIN = 'admin';
    const REVIEWER = 'reviewer';
}
```

The `Enum` rule can be used like this:

```php
// in a `FormRequest`

public function rules()
{
    return [
        'role' => [new Enum(UserRole::class)],
    ];
}
```

The request will only be valid if `role` contains `ADMIN` or `REVIEWER`.

### `modelsExist`

Determine if all of the values in the input array exist as attributes for the given model class. 

By default the rule assumes that you want to validate using `id` attribute. In the example below the validation will pass if all `model_ids` exist for the `Model`.


```php
// in a `FormRequest`

public function rules()
{
    return [
        'model_ids' => ['array', new ModelsExist(Model::class)],
    ];
}
```


You can also pass an attribute name as the second argument. In the example below the validation will pass if there are users for each email given in the `user_emails` of the request.

```php
// in a `FormRequest`

public function rules()
{
    return [
        'user_emails' => ['array', new ModelsExist(User::class, 'emails')],
    ];
}
```

### `futureDate`

Determine if a date is in the future.

```php
// in a `FormRequest`

public function rules()
{
    return [
        'date_from' => ['date', new FutureDate()],
    ];
}
```

#### Date format

By default this rule will use `Y-m-d` as the date format, it can be overridden in the constructor.

```php
new FutureDate('Y-m-d H:i:s');
```

### `pastDate`

Determine if a date is in the past.

```php
// in a `FormRequest`

public function rules()
{
    return [
        'date_from' => ['date', new PastDate()],
    ];
}
```

#### Date format

By default this rule will use `Y-m-d` as the date format, it can be overridden in the constructor.

```php
new PastDate('Y-m-d H:i:s');
```

### `dateBetween`

Determine if a date is between two other dates.

```php
// in a `FormRequest`

public function rules()
{
    return [
        'date_from' => [
            'date', 
            new DateBetween(now()->subWeek(), now()->addWeek()),
        ],
    ];
}
```

By default the boundary dates are included, you can exluding them by calling `excludeBoundaries`.

```php
(new DateBetween(now()->subWeek(), now()->addWeek()))
    ->excludeBoundaries()
```

If you only want to determine whether a date is between full days, you can use `withoutTime`.

```php
(new DateBetween(now()->subWeek(), now()->addWeek()))
    ->withoutTime()
```

#### Date format

By default this rule will use `Y-m-d` as the date format, it can be overridden in the constructor.

```php
new DateBetween($from, $to, 'Y-m-d H:i:s');
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
