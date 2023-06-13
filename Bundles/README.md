# Put your bundles here

Structure of bundle (example):

Project root
    Bundles
        BundleName - Name of bundle
            Controller - Controller folder, can be different
            Locales - Directory with gettext locales
            View - Directory with bundle views
            BundleName.php

## BundleName example

Bundle must implements BundleInterface with this structure

```php
<?php

namespace Bundles\TestBundle;

use Core\Interfaces\BundleInterface;

class MyBundle implements BundleInterface
{

    // Configuration of this bundle
    public function getConfig(): array
    {
        return [];
    }

    // Array of bundles that conflicts with this
    public function getConflicts(): array
    {
        return [];
    }

    // Bundle description
    public function getDescription(): string
    {
        return 'My Bundle Description';
    }

    // Bundle name
    public function getName(): string
    {
        return 'mybundle';
    }

    // Bundle menu items to add to menu
    public function getMenu(): array
    {
        return [
            'frontend' => [
                [
                    'key' => 'home',
                    'label' => 'Home',
                    'url' => '{url}'
                ],
                [
                    'key' => 'about',
                    'label' => 'About',
                    'url' => '{url}/about'
                ]
            ],
            'admin' => [
                [
                    'key' => 'users',
                    'label' => 'Users',
                    'url' => '{url}/users'
                ],
                [
                    'key' => 'settings',
                    'label' => 'Settings',
                    'url' => '{url}/settings'
                ]
            ]
        ];
    }

    // List of bundles that this bundle require
    public function getRequired(): array
    {
        return [];
    }

    // Get plugin path
    public function getPath(): string
    {
        return __DIR__;
    }

    // Route groups of bundle
    public function getRoutes(): array
    {
        return [
            'mybundle' => [
                'key' => $this->getName(),
                'type' => 'web',
                'address' => '/mybundle',
                'namespace' => 'Bundles\TestBundle\Controller',
                'params' => 7,
                'multilang' => true
            ]
        ];
    }
}
```
