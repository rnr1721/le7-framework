# rnr1721/le7-framework

Le7 framework is minimalistic PHP MVC framework, written in PHP.

This is a skeleton (empty application for use with le7 framework)

## What it can?

- Create Web, REST API or CLI applications
- Multilingual by default. Every page can be displayed on every language from config
- Use any template engine - Twig, Smarty or clean PHP if need
- Themes support for more extensible work with design
- Use controllers for different route groups in different namespaces
- Easy extending of framework functionality
- Easy etnity framework with data providers for validating arrays, forms etc...
- use PSR standards - cache, events, messages, middleware, request handler etc
- Easy to replace some functional as logger, cache, template engine and other
- Use any container, core use only get and has methods of ContainerInterface
- Use any cache - filesystem, memcached, null, etc... Can easy write own.
- Store flash messages in cookies and in session
- Able to write own session handler
- Very simple routing
- Internal validation class, but You can use any own
- CSRF protection for POST, PUT, PATCH, DELETE methods.
- Easy inject dependencies in controller constructor and action methods
- Easy inject dependencies in middleware, events
- Easy-understanded container configuration
- Use minimal set of dependencies, light-weight
- Easy configure CSP and other security headers

## In plans

- Tests
- Core documentation
- Database management package
- User management package

## Requirements

- PHP 8.1 or higher
- Apache or Nginx web servers
- Working on Workerman, but I dont know how serve static content (js, img, css)

## Contributing

If you're a developer looking to contribute to an open source project, we
invite you to check out our project and consider joining our community of
contributors. You are welcome!

## General

This skeleton use PHP-DI as dependency injection container, but you can use any
DI container with autowiring. Framework core uses only get and set methods
of ContainerInterface. But, in this case you need to edit this skeleton.
Also, this skeleton use Nyholm PSR http-message reslisation but you can use
any.

## Install
You can install le7 framework with composer
In current directory:
```
composer create-project rnr1721/le7-framework .
```
In some directory:
```
composer create-project rnr1721/le7-framework ./myle7framework
```

In any folder present README.md file, where you can find information about
engine functional.

## Web server configuration

### Apache

This is standard configuration of Apache web server
This file (.htaccess) already in public folder

```apache
RewriteEngine On
RewriteBase /

# Route everything else to index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]

## Folder structure of project
```

### Nginx

Le7 engine may work on nginx fine, but I not testing it at this moment.
In the future, I will install this server and provide the configuration for nginx.

### Built-in PHP server for testing:

```bash
$ ./runserver.sh
```

### Workerman

I checked in workerman and it worked. But the problem is that I don't know how
to serve static files using workerman. But right now, as an API engine, it’s
quite useable in Workerman

Running in workerman:

```bash
$ php ./workerman.php
```

## Folders topology

```
PROJECT_ROOT
    App - application dir.
        Classes - Own classes for developed project
        Controller - Dir for controllers by default. Can change.
            Api - Api controllers
            Cli - CLI commands
            Web - Web controllers
        Locales - Gettext locales
        Middleware - User middlewares
        Model - User models for tables
        View - Templates for all themes and templates themes folders
            main - main theme templates
        ViewExtensions - Extensions for Twig, Smarty etc
    config
        di - Configuration of DI container
    public - Web server public dir
        libs - Theme-independent js, css, images etc
            bootstrap5 - bootstrap
            debugbar - debugbar assets for dev mode.
            fonts - Fonts
        themes - Themes directory
            main - Default theme (as example)
                css - Css files for main theme
                fonts - Fonts files for main theme
                images - Images files for main theme
                js - JS files for main theme
    uploads - Internal uploads dir
    var - Directory for cache, temp, logs and similar data
        cache - Cache folder
        containers - Di container folder (PHP-Di)
        logs - Logs folder if filesystem logs
        routes - cached routes data objects
        sessions - sessions dir if filesystem sessions
        temp - temp dir for any purposes
        templates_cache - templates cache for your template engine
        templates_compiled - compiled templates dir for your template engine
```
