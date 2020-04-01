# Changelog

All notable changes to `laravel-validation-rules` will be documented in this file

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
