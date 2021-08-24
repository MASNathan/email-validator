# Email Validator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masnathan/email-validator.svg?style=flat-square)](https://packagist.org/packages/masnathan/email-validator)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masnathan/email-validator/run-tests?label=tests)](https://github.com/masnathan/email-validator/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masnathan/email-validator/Check%20&%20fix%20styling?label=code%20style)](https://github.com/masnathan/email-validator/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/masnathan/email-validator.svg?style=flat-square)](https://packagist.org/packages/masnathan/email-validator)

This is an easy way to check if a email address is acceptable so you can avoid fake/invalid users on your database.

What this API does is check if the email address is correctly formatted, is from a disposable or temporary service and the domain is reachable. This way you can filter out spam and one-shot accounts decreasing the rate of fake or invalid accounts on your database.

## Installation

You can install the package via composer:

```bash
composer require masnathan/email-validator
```

## Usage

```php
$email-validator = new Masnathan\EmailValidator();
echo $email-validator->echoPhrase('Hello, Masnathan!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [André Filipe](https://github.com/masnathan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
