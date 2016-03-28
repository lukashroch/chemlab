
[![Build Status](https://travis-ci.org/swiggles/laravel-memcache.svg?branch=master)](https://travis-ci.org/swiggles/laravel-memcache)

## Laravel 5 Memcache Driver

Update: added Laravel 5.2 support, not BC

If you're on a windows PC and you're having trouble setting up memcached with laravel then this is what you need.

Handy for when you want to use a taggable cache store and test it out on your localhost.

========

### Installation

Make sure you've got both a memcached server and the memcache php extension installed.
http://stannesi.blogspot.co.uk/2011/11/how-to-install-memcache-on-xampp.html 

Add the package to your composer.json and run composer update.

Update: added Laravel 5.2 support, not BC
```php
"swiggles/memcache": "~2.0"
```

Use the below for older versions of laravel 5
```php
"swiggles/memcache": "~1.0"
```

Add the memcache service provider in app/config/app.php:

```php
'Swiggles\Memcache\MemcacheServiceProvider',
```

You may now update your config/cache.php config file to use memcache
```php
	'default' => 'memcache',
```

You may now update your config/session.php config file to use memcache

```php
	'driver' => 'memcache',
```

**Notice: This memcache driver uses the same config as Memcached**

This package was originally a fork of https://github.com/igormatkovic/Laravel-4-Memcache. It has been modified to work with Laravel 5 which meant that more than just the service provider needed changing.
