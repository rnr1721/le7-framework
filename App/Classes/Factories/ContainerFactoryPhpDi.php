<?php

namespace App\Classes\Factories;

use Core\Interfaces\ContainerFactoryInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

class ContainerFactoryPhpDi implements ContainerFactoryInterface
{

    private string $diCompiledFolder;
    private string $configFolder = '';

    public function __construct(
            string $configFolder,
            string $diCompiledFolder)
    {
        $this->configFolder = $configFolder;
        $this->diCompiledFolder = $diCompiledFolder;
    }

    public function getContainer(bool $isProduction): ContainerInterface
    {

        $definitions = $this->getDefinitions();

        $builder = new ContainerBuilder();

        $builder->useAttributes(true);

        if ($isProduction) {
            $builder->enableCompilation($this->diCompiledFolder);
            $builder->writeProxiesToFile(true, $this->diCompiledFolder);
        }

        $builder->addDefinitions($definitions);
        return $builder->build();
    }

    public function getDefinitions(): array
    {
        $definitions = [];
        $files = glob($this->configFolder . DIRECTORY_SEPARATOR . "*Conf.php");
        foreach ($files as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                $array = require $filename;
                if (is_array($array)) {
                    $definitions = array_merge($definitions, $array);
                }
            }
        }
        return $definitions;
    }

}
