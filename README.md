# DatabaseAdapter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A simple package that abstracts away the process of connecting to a database using `PDO` and interacting with the connection.  
All code is written using PSR1 and PSR2 guidelines.

## Install

Via Composer

``` bash
$ composer require emmanix2002/database-adapter
```

## Usage   
We start by creating an instance of the class; it provides a utility `create()` method that takes in the settings as an array and 
fills in defaults where needed.    
It is possible to change the defaults by calling the `setDefault()` static method.

``` php
$config = ['host' => 'localhost', 'user' => 'user', 'password' => 'password', 'schema' => 'schema_name'];

$adapter = Emmanix2002\MySqlAdapter::create($config);
// OR
$adapter = new Emmanix2002\MySqlAdapter('host', 'schema_name', 'user', 'password');

$record = $adapter->selectOne('SELECT * FROM `Users` WHERE `user_id`=?', 21134);
var_dump($record);
```

### Usage: defaults
```php
use Emmanix2002\MySqlAdapter;

MySqlAdapter::setDefault('host', 'default_hostname');
MySqlAdapter::setDefault('schema', 'default_schema');
MySqlAdapter::setDefault('user', 'default_user');
MySqlAdapter::setDefault('password', 'default_password');

$adapterDefault = MySqlAdapter::create();
// create an adapter using the defaults

$adapter = MySqlAdapter::create(['host' => 'another_hostname']);
// equivalent to new MySqlAdapter('another_hostname', 'default_schema', 'default_user', 'default_password');
```

### Usage: Querying
There are a few methods that help with querying, they are:    
- `exec()`
- `selectAll()`
- `selectOne()`   

`exec()` should be called directly for all queries that do not return an actual response i.e. every query excluding `SELECT` 
statements. It is called by both `select*()` methods, but it's much easier using them for `SELECTing` as opposed to calling 
`exec()` yourself. `exec()` uses `prepared statements` on all queries passed to it.    
Below are examples:    
```php
$sql = 'SELECT * FROM `users` WHERE `user_email`=? AND `user_status`=?';
$record = $adapter->selectOne($sql, 'username@example.com', 1);

// it is also possible to do the same like so:
$args = ['username@example.com', 1];
$record = $adapter->selectOne($sql, ...$args);

// both will return the same value

```

`exec()` always returns a value; depending on the arguments passed:    
- `true`: is returned if the query was successfully executed and the `$isSelect` parameter is set to `FALSE`
- `false`: is returned if the query execution failed, irrespective of the value of the `$isSelect` parameter
- `array`: is returned if the query was successful and the `$isSelect` parameter is set to `TRUE`. `select*()` methods always set `$isSelect` to `TRUE`

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

[ico-version]: https://img.shields.io/packagist/v/emmanix2002/database-adapter.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/emmanix2002/database-adapter/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/emmanix2002/database-adapter.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/emmanix2002/database-adapter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/emmanix2002/database-adapter.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/emmanix2002/database-adapter
[link-travis]: https://travis-ci.org/emmanix2002/database-adapter
[link-scrutinizer]: https://scrutinizer-ci.com/g/emmanix2002/database-adapter/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/emmanix2002/database-adapter
[link-downloads]: https://packagist.org/packages/emmanix2002/database-adapter
[link-author]: https://github.com/emmanix2002
[link-contributors]: ../../contributors
