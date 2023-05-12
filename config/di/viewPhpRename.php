<?php

use Core\View\Php\PhpViewAdapter;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    View::class => factory(function (ContainerInterface $c) {
        /** @var PhpViewAdapter $adapter */
        $adapter = $c->get(PhpViewAdapter::class);
        return $adapter->getView();
    })
];
