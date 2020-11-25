# A set of useful Laravel validation rules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-validation-rules.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-validation-rules)
![Tests](https://github.com/spatie/package-skeleton-laravel/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-validation-rules.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-validation-rules)

This repository contains some useful Laravel validation rules.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-validation-rules.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-validation-rules)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-validation-rules
```

The package will automatically register itself.

### Translations

If you wish to edit the package translations, you can run the following command to publish them into your `resources/lang` folder

```bash
php artisan vendor:publish --provider="Spatie\ValidationRules\ValidationRulesServiceProvider"
```

## Available rules

- [`Authorized`](#authorized)
- [`CountryCode`](#countrycode)
- [`Enum`](#enum)
- [`ModelsExist`](#modelsexist)
- [`Delimited`](#delimited)

### `Authorized`

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

use Spatie\ValidationRules\Rules\Authorized;

public function rules()
{
    return [
        'model_id' => [new Authorized('edit', TestModel::class)],
    ];
}
```

Optionally, you can provide an authentication guard as the third parameter.

```php
new Authorized('edit', TestModel::class, 'guard-name')
```

#### Model resolution
If you have implemented the `getRouteKeyName` method in your model, it will be used to resolve the model instance. For further information see [Customizing The Default Key Name](https://laravel.com/docs/7.x/routing)

### `CountryCode`

Determine if the field under validation is a valid ISO3166 country code.

```php
// in a `FormRequest`

use Spatie\ValidationRules\Rules\CountryCode;

public function rules()
{
    return [
        'country_code' => ['required', new CountryCode()],
    ];
}
```

If you want to validate a nullable country code field, you can call the `nullable()` method on the `CountryCode` rule. This way `null` and `0` are also passing values:

```php
// in a `FormRequest`

use Spatie\ValidationRules\Rules\CountryCode;

public function rules()
{
    return [
        'country_code' => [(new CountryCode())->nullable()],
    ];
}
```

### `Enum`

This rule will validate if the value under validation is part of the given enum class. We assume that the enum class has a static `toArray` method that returns all valid values. If you're looking for a good enum class, take a look at [spatie/enum](https://github.com/spatie/enum) or [myclabs/php-enum](https://github.com/myclabs/php-enum).

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

use Spatie\ValidationRules\Rules\Enum;

public function rules()
{
    return [
        'role' => [new Enum(UserRole::class)],
    ];
}
```

The request will only be valid if `role` contains `ADMIN` or `REVIEWER`.

### `ModelsExist`

Determine if all of the values in the input array exist as attributes for the given model class. 

By default the rule assumes that you want to validate using `id` attribute. In the example below the validation will pass if all `model_ids` exist for the `Model`.


```php
// in a `FormRequest`

use Spatie\ValidationRules\Rules\ModelsExist;

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

use Spatie\ValidationRules\Rules\ModelsExist;

public function rules()
{
    return [
        'user_emails' => ['array', new ModelsExist(User::class, 'emails')],
    ];
}
```

### `Delimited`

This rule can validate a string containing delimited values. The constructor accepts a rule that is used to validate all separate values.

Here's an example where we are going to validate a string containing comma separated email addresses.

```php
// in a `FormRequest`

use Spatie\ValidationRules\Rules\Delimited;

public function rules()
{
    return [
        'emails' => [new Delimited('email')],
    ];
}
```

Here's some example input that passes this rule:

- `'sebastian@example.com, alex@example.com'`
- `''`
- `'sebastian@example.com'`
- `'sebastian@example.com, alex@example.com, brent@example.com'`
- `' sebastian@example.com   , alex@example.com  ,   brent@example.com  '`

This input will not pass:
- `'@example.com'`
- `'nocomma@example.com nocommatoo@example.com'`
- `'valid@example.com, invalid@'`

#### Setting a minimum
You can set minimum amout of items that should be present:

```php
(new Delimited('email'))->min(2)
```

- `'sebastian@example.com, alex@example.com'` // passes
- `'sebastian@example.com'` // fails

#### Setting a maximum

```php
(new Delimited('email'))->max(2)
```

- `'sebastian@example.com'` // passes
- `'sebastian@example.com, alex@example.com, brent@example.com'` // fails

#### Allowing duplicate items

By default the rule will fail if there are duplicate items found.

- `'sebastian@example.com, sebastian@example.com'` // fails

You can allowing duplicate items like this:

```php
(new Delimited('numeric'))->allowDuplicates()
```

Now this will pass: `1,1,2,2,3,3`

#### Customizing the separator

```php
(new Delimited('email'))->separatedBy(';')
```

- `'sebastian@example.com; alex@example.com; brent@example.com'` // passes
- `'sebastian@example.com, alex@example.com, brent@example.com'` // fails

#### Skip trimming of items

```php
(new Delimited('email'))->doNotTrimItems()
```

- `'sebastian@example.com,freek@example.com'` // passes
- `'sebastian@example.com, freek@example.com'` // fails
- `'sebastian@example.com , freek@example.com'` // fails

#### Composite rules

The constructor of the validator accepts a validation rule string, a validate instance, or an array.

```php
new Delimited('email|max:20')
```
- `'short@example.com'` // passes
- `'invalid'` // fails
- `'loooooooonnnggg@example.com'` // fails

#### Passing custom error messages

The constructor of the validator accepts a custom error messages array as second parameter.

```php
// in a `FormRequest`

use Spatie\ValidationRules\Rules\Delimited;

public function rules()
{
    return [
        'emails' => [new Delimited('email', $this->messages())],
    ];
}

public function messages()
{
    return [
        'emails.email' => 'Not all the given e-mails are valid.',
    ];
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
