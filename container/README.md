# Dependency injection config folder

This is default DI config folder. Here you can make many great things:

- Change default components (for example, change logger or PSR message component)
- Change caching options (for example switch cache from files to memcached)
- Make cookies and sessions settings
- Switch between Twig, Smarty and clean PHP templating engines
- And many many other...

## Switch between Smarty, Twig and PHP template engines

At first, install PHP engine that you need (if not installed):

```shell
composer require rnr1721/le7-view-twig
```
or
```shell
composer require rnr1721/le7-view-smarty
```

In ./config/di folder you can find three files:

- viewPhpRename.php
- viewSmartyRename.php
- viewTwigConf.php

DI container understand filenames with names *Conf.php. filenames with other
suffixes will be ignored. For example we want use Smarty instead twig:

1. we need to rename viewTwigConf.php to viewTwigRename.php
2. we need to rename viewSmartyRename to viewSmartyConf.php

Thats all! Now you can use Smarty templates in your projects.
Also, in you files you can set specific options for your favorite template engine

## Dependency Injection

./config/di
In di folder stored config of PSR container. This skeleton created with
using of PHP-DI, but core of framework (le7-core) can work with any PSR
containers, because in core used only get and has methods of ContainerInterface.
Also, with DI you can change many components of framework - for example:

- Choose different PSR logger (or extend current)
- Choose different PSR SimpleCache (or extend current)
- Change or extend any component

## Change cache system from filesystem to memcached

In psrConf.php you can find this code:
```php
    CacheInterface::class => factory(function () {
        // File cache by default
        $factory = new SCFactoryGeneric();
        $cachePath = BASE_PATH . DS . 'var' . DS . 'cache';
        return $factory->getFileCache($cachePath);
    })
```php

You can choose another cache system in this way:

```shell
composer require rnr1721/le7-cache-memcache
```

And at final, change configuration of DI container:

```php
use Core\Cache\SCFactoryMemcacheGeneric;
```

```php
    CacheInterface::class => factory(function () {
        $factory = new SCFactoryMemcacheGeneric;
        // return $factory->getMemcached("127.0.0.1", $port = 11211);
        return $factory->getMemcache("127.0.0.1", $port = 11211);
    })
```

Of course, memcached server must be configured
Also, You can use any PSR SimpleCache implementation

## Choose different logger

Le7 framework comes with internal logger and You can extend them.
But you can use any different logger:

In psrConf.php you can find this code:

```php
    LoggerInterface::class => factory(function (ContainerInterface $c) {
        $factory = new LoggerFactoryGeneric();
        $config = $c->get(Config::class);
        $logFile = $config->stringf('loc.var') . DS . 'logs' . DS . 'system.log';
        return $factory->logFile($logFile);
    }),
```

And change it to create own logger (for example monolog)

```php
    LoggerInterface::class => factory(function (ContainerInterface $c) {
        // Create own PSR logger (LoggerInterface) here
        return $mylogger;
    }),
```

## Cookie and session settings

You can change cookie and session cookie settings in file sysyemConf.php

```php
    SessionInterface::class => factory(function (ContainerInterface $c) {
        /** @var Config $config */
        $config = $c->get(Config::class);
        $storePath = $config->stringf('loc.var') . DS . 'sessions';
        $session = new SessionNative(false, null, null, $storePath);
        $sessionParams = [
            'lifetime' => 86400,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ];
        $session->applyParams($sessionParams);
        return $session;
    }),
    CookieInterface::class => factory(function () {
        $cookiesConfig = new CookieConfigDefault([
            'domain' => '',
            'httpOnly' => true,
            'path' => '/',
            'isSecure' => false,
            'time' => 3600,
            'sameSite' => 'Lax'
        ]);
        return new CookiesNative($cookiesConfig);
    }),
```
Also, you can extend rnr1721/le7-cookie-wrapper component for
use different session handler

## Flash messages from session or cookies

In file systemConf you can change place where stored flash messages

In this case flash messages stored in session:

```php
    MessageCollectionInterface::class => factory(function (ContainerInterface $c) {
        $factory = $c->get(MessageFactoryInterface::class);
        return $factory->getMessagesSession();
    }),
    MessageCollectionFlashInterface::class => factory(function (ContainerInterface $c) {
        $factory = $c->get(MessageFactoryInterface::class);
        return $factory->getMessagesSession();
    }),
```

And in this case messages stored in cookies:

```php
    MessageCollectionInterface::class => factory(function (ContainerInterface $c) {
        /** @var MessageFactory $factory */
        $factory = $c->get(MessageFactoryInterface::class);
        return $factory->getMessagesCookie();
    }),
    MessageCollectionFlashInterface::class => factory(function (ContainerInterface $c) {
        $factory = $c->get(MessageFactoryInterface::class);
        return $factory->getMessagesCookie();
    }),
```
