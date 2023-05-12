# CLI command default folder
Put your controllers for CLI here.
for example:

```php
<?php

namespace App\Controller\Cli;

use App\Controller\ControllerCli;

class TestController extends ControllerCli
{

    /**
     * Test option description
     * @var string
     */
    public string $opt_option1 = 'value of option 1';
    
    /**
     * Test option 2 description
     * @var string
     */
    public string $opt_option2;

    public function indexAction()
    {
        $this->stdout('Test dummy controller');
    }

}
```

You can change PSR namespace for CLI controllers in config by changing
option commandNamespace

For example:

```php
"commandNamespace" => "App\Controller\Cli",
```
