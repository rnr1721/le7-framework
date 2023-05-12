<?php

use Core\Entify\Interfaces\EntificationInterface;
use Core\Entify\RulesLoaderClass;
use Psr\Container\ContainerInterface;
use Core\Entify\Interfaces\RulesLoaderInterface;
use Core\Entify\Entification;
use function DI\factory;

return [
    EntificationInterface::class => factory(function (ContainerInterface $c) {
        // Get Entification object with rules stored in classes
        return new Entification($c->get(RulesLoaderInterface::class));
    }),
    RulesLoaderInterface::class => factory(function(){
        // Namespace where Entify will find rules
        return new RulesLoaderClass('\\App\\Entity\\');
    })
];
