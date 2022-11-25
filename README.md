# Scrubber
<p>
<a href="https://packagist.org/packages/clntdev/scrubber"><img src="https://poser.pugx.org/clntdev/scrubber/version" alt="Stable Build" /></a>
<a href="https://github.com/clnt/scrubber/actions"><img src="https://github.com/clnt/scrubber/actions/workflows/.github-actions.yml/badge.svg" alt="CI Status" /></a>
<a href="https://codecov.io/gh/clnt/scrubber"><img src="https://codecov.io/gh/clnt/scrubber/branch/production/graph/badge.svg?token=XD5TG940EV" alt="Code Coverage"/></a>
</p>
Scrubber is a minimal PHP package with only one dependency, it allows you to define a PHP configuration file which can help update database fields with various predefined or random values.

This is perfect for when you need a copy of a production database to work on and need to erase sensitive content.

## Installation

Install via composer by running: `composer require clntdev/scrubber`

## Usage

### Configuration File

The package relies on a valid PHP configuration file to function correctly, this file returns a simple array which maps out the tables, fields and their details so it knows which handler to use.

A handler is detected from the `value` given for a field.

- A field can have a `primary_key` defined on it if you want to use an alternative column to fetch database records, the default is `id`.
- A field can have a `handler` defined on it if you wish to override the detected handler.
- A field can have a `type` defined on it which can be used to define the field as a certain data type such as `pid` for GDPR purposes (this is useful in the methods listed further down)

Here is an example configuration used in the unit tests:

```php
<?php

use ClntDev\Scrubber\Handlers\FakerHandler;

return [
    'users' => [
        'first_name' => [
            'primary_key' => 'id',
            'value' => 'faker.firstName',
            'type' => 'pid',
        ],
        'last_name' => [
            'value' => 'faker.lastName',
            'type' => 'pid',
        ],
        'email' => [
            'value' => 'faker.email',
            'handler' => FakerHandler::class,
            'type' => 'pid',
        ],
        'toggle' => [
            'value' => static fn (): bool => true,
        ],
    ],
];
```

### Interfaces

This package implements two interfaces which classes need to be created for, these will then be passed into and used by the main `Scrubber` class.

#### Database Class

This class should implement the `ClntDev\Scrubber\Contracts\DatabaseUpdate` interface which will require an `update` and `fetch` method to be defined.

Define the `fetch` method to return an array of values such as IDs using the given `$table` and `$primaryKey` variables to fetch them from your chosen data source.

Define the `update` method to update your chosen data source using the given `$table`,`$field` and `$value` parameters.

#### Logger Class

This class should implement the `ClntDev\Scrubber\Contracts\Logger` interface which will require a `log` method to be defined.

Define the `log` method to log any given exception message thrown during the process to your preferred logging method.

### Scrubber Class

Once the configuration file has been defined and the classes above setup, all that is left to do now is initialise the `Scrubber` class. This will allow the database update to be run and also fields listed out depending upon the type given.

The `ClntDev\Scrubber\Scrubber` class can be newed up normally or a static `make` method has been provided to make chain calls tidier:

```php
$scrubber = Scrubber::make('/path/to/config.php', $databaseClass, $loggerClass)
```

Pass in the absolute path to the configuration file, the created database class and the created logger class.

### Methods

`run()` - This is the main method and will run all of the handlers from the parsed configuration file modifying the database.

`getFieldList(string $type = 'pid')` - This method will return an array of fields for the given type, this defaults to `pid`.

`getFieldListAsString(string $type = 'pid')` - This method will return a comma separated string of fields for the given type, this defaults to `pid`.

## Built-in Handlers

- **Faker** - Randomly generate strings using the fakerphp/faker library with a value input such as `faker.firstName`
- **Callable** - Pass closures or callable classes
- **Object** - Pass an object with a `handle` or `__invoke` method on it
- **Integer** - Casts the value input to an integer if numeric
- **String** - Casts the value input to a string


