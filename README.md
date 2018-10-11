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


## Rules

- [`authorized`](#authorized)
- [`enum`](#enum)
- [`modelIds`](#modelids)

### `authorized`

Determine if the user is authorized to perform an ability. 

With this definition:

```php
Gate::define('lowUserId', function (User $user) {
    return $user->id <= 100;
});
```

All users with an id more than 100 will receive a validation error.


```php
// in a `FormRequest`

public function rules()
{
    return [
        'field_under_validation' => [new Authorized('lowUserId')],
    ];
}
```

Here's an example where we validate if the user can edit a `Model` with the `model_id` value as its primary key.

```php
// in a `FormRequest`

public function rules()
{
    return [
        'model_id' => [new Authorized('edit', Model::class)],
    ];
}
```

### `enum`

This rule will validate if the value under validation is part of the given enum class. We assume that the enum class has a static `toArray` method that returns all valid values. If you're looking for a good enum class, take a look at [myclabs/php-enum](https://github.com/myclabs/php-enum);

Given this enum class

```php
class UserRole extends MyCLabs\Enum\Enum
{
    const ADMIN = 'admin';
    const REVIEWER = 'reviewer';
}
```

you can use the `Enum` rule like this:

```php
// in a `FormRequest`

public function rules()
{
    return [
        'role' => [new Enum(UserRole::class)],
    ];
}
```

The request will only be valid if the role contains `admin` or `reviewer`.

### `modelIds`

Determine if all the given ids exist for the given model class. 

```php
// in a `FormRequest`

public function rules()
{
    return [
        'model_ids' => ['array', new ModelIds(Model::class)],
    ];
}
```

The validation will pass if all ids given in `model_ids` exist for the `Model`.

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
