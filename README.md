# DatabaseAdapter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

The main aim of this package is to abstract away the process of connecting to a database using `PDO`. 
All code is written using PSR1 and PSR2 guidelines.

## Install

Via Composer

``` bash
$ composer require Emmanix2002/DatabaseAdapter
```

## Usage

``` php
$config = ['host' => 'localhost', 'user' => 'user', 'password' => 'password', 'schema' => 'schema_name'];

$adapter = Emmanix2002\PdoMySqlAdapter::create($config);
// OR
$adapter = new Emmanix2002\PdoMySqlAdapter('host', 'schema_name', 'user', 'password');

$record = $adapter->selectOne('SELECT * FROM `Users` WHERE `user_id`=?', 21134);
var_dump($record);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email emmanix2002@gmail.com instead of using the issue tracker.

## Credits

- [Okeke Emmanuel][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/emmanix2002/DatabaseAdapter.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/emmanix2002/DatabaseAdapter/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/emmanix2002/DatabaseAdapter.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/emmanix2002/DatabaseAdapter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/emmanix2002/DatabaseAdapter.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/emmanix2002/DatabaseAdapter
[link-travis]: https://travis-ci.org/emmanix2002/DatabaseAdapter
[link-scrutinizer]: https://scrutinizer-ci.com/g/emmanix2002/DatabaseAdapter/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/emmanix2002/DatabaseAdapter
[link-downloads]: https://packagist.org/packages/emmanix2002/DatabaseAdapter
[link-author]: https://github.com/emmanix2002
[link-contributors]: ../../contributors
