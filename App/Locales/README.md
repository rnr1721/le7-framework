# Place for gettext locales

You can configure locales in ./config/locales.php file

Example:

```php
<?php

return [
    'defaultLanguage' => 'en',
    'locales' => [
        'ru' => [
            'name' => 'ru_RU',
            'label' => 'Русский'
        ],
        'en' => [
            'name' => 'en_US',
            'label' => 'English'
        ],
        'ua' => [
            'name' => 'es_ES',
            'label' => 'Espana'
        ]
    ]
];
```
