# Changelog

All notable changes to `laravel-validation-rules` will be documented in this file

## 3.4.2 - 2025-02-24

### What's Changed

* Only allow string values to be processed by @carestad in https://github.com/spatie/laravel-validation-rules/pull/74

### New Contributors

* @carestad made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/74

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.4.1...3.4.2

## 3.4.1 - 2025-02-17

### What's Changed

* Fixed typo in README.md by @snipe in https://github.com/spatie/laravel-validation-rules/pull/71
* Laravel 12.x Compatibility by @laravel-shift in https://github.com/spatie/laravel-validation-rules/pull/72

### New Contributors

* @snipe made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/71

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.4.0...3.4.1

## 3.4.0 - 2024-03-02

### What's Changed

* Fix test badge by @erikn69 in https://github.com/spatie/laravel-validation-rules/pull/67
* Laravel 11.x Compatibility by @laravel-shift in https://github.com/spatie/laravel-validation-rules/pull/70

### New Contributors

* @erikn69 made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/67

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.3.1...3.4.0

## 3.3.1 - 2023-05-29

### What's Changed

- Convert test to pest by @lloricode in https://github.com/spatie/laravel-validation-rules/pull/65
- Add parameter column on `Authorized`, use php8 syntax by @lloricode in https://github.com/spatie/laravel-validation-rules/pull/64
- Use pest on composer test script by @lloricode in https://github.com/spatie/laravel-validation-rules/pull/66

### New Contributors

- @lloricode made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/65

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.3.0...3.3.1

## 3.3.0 - 2023-05-09

### What's Changed

- use str_getcsv instead of explode in Delimited rule by @ragulka in https://github.com/spatie/laravel-validation-rules/pull/62

### New Contributors

- @ragulka made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/62

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.2.2...3.3.0

## 3.2.2 - 2023-01-25

### What's Changed

- Add PHP 8.2 Support by @patinthehat in https://github.com/spatie/laravel-validation-rules/pull/57
- Install Laravel Pint by @imdhemy in https://github.com/spatie/laravel-validation-rules/pull/59

### New Contributors

- @patinthehat made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/57
- @imdhemy made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/59

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.2.1...3.2.2

## 3.2.1 - 2022-08-01

- fix chaining `doNotTrimItems`

## 3.2.0 - 2022-01-12

## What's Changed

- fix psr version by @iamfarhad in https://github.com/spatie/laravel-validation-rules/pull/50
- Allow Laravel 9

## New Contributors

- @iamfarhad made their first contribution in https://github.com/spatie/laravel-validation-rules/pull/50

**Full Changelog**: https://github.com/spatie/laravel-validation-rules/compare/3.1.1...3.2.0

## 3.1.1 - 2021-08-15

- fix custom validation messages on delimited rule

## 3.1.0 - 2021-08-06

- add ISO4217 currency validation rule (#48)

## 3.0.0 - 2020-11-30

- move iso3166 package to `suggest`

## 2.7.1 - 2020-11-30

- add support for PHP 8

## 2.7.0 - 2020-10-28

- support custom error messages (#44)

## 2.6.1 - 2020-09-08

- add support for Laravel 8

## 2.6.0 - 2020-09-01

- adds the ability to specify an auth guard, and uses route name resolution for models (#41)

## 2.5.2 - 2020-07-01

- fix translation (#40)

## 2.5.1 - 2020-04-01

- fix nested attributes validation (#38)

## 2.5.0 - 2020-03-02

- add support for Laravel 7

## 2.4.0 - 2019-09-04

- add support for Laravel 6

## 2.3.4 - 2019-06-14

- fix validation messages

## 2.3.3 - 2019-06-12

- fix for determining the amount of value in the `Delimited` rule

## 2.3.2 - 2019-05-15

- fix for delimiting rule with a minimum of 1

## 2.3.1 - 2019-05-16

- fix for validating arrays

## 2.3.0 - 2019-05-16

- added `Delimited`

## 2.1.1 - 2019-02-27

- use PHPUnit 8 to run tests

## 2.1.0 - 2019-01-02

- add `CountryCode` rule for ISO3266 country codes

## 2.0.0 - 2018-12-19

- move all validation message translations to the `validation.*` group to be more consistent with Laravel
- add relevant data for each rule to validation message translations (see `message` method for each rule)

## 1.0.3 - 2018-10-18

- fix `Enum` rule

## 1.0.2 - 2018-10-14

- fix typo in validation message

## 1.0.1 - 2018-10-12

- fix `Authorized` rule

## 1.0.0 - 2018-10-12

- initial release
