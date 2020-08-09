![logo](https://github.com/nightwolf93/brisk/blob/master/logo.png?raw=true)

# php-brisk

[![CircleCI](https://circleci.com/gh/nightwolf93/php-brisk.svg?style=svg)](https://github.com/nightwolf93/php-brisk)

**php-brisk** is a php library for interact with the Brisk API

## Documentation

First create a instance of BriskClient

```php
$client = new BriskClient( 'http://localhost:3000', 'master', 'changeme' );
```

Create a link

```php
$link = $client->createLink( 'https://github.com/nightwolf93/brisk', 30000, 5 );
```

You can check the official brisk api too : https://nico-style931.gitbook.io/brisk/

## Composer

```
composer require nightwolf93/php-brisk
```

## Test

```
make test
```

## Authors

Nightwolf93
