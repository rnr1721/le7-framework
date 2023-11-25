<?php

use Core\Interfaces\ConfigInterface;
use Core\Database\Redbean\Interfaces\DbDriverInterface;
use Core\Entify\Interfaces\EntificationInterface;
use Core\Entify\Interfaces\RulesLoaderInterface;
use Core\Database\Redbean\Interfaces\EntificationSqlInterface;
use Core\Database\Redbean\Interfaces\DbInterface;
use Core\Database\Redbean\Interfaces\DbConnInterface;
use Core\Database\Redbean\EntificationSql;
use Core\Database\Redbean\Drivers\DbSql;
use Core\Database\Redbean\Drivers\DbSqlite;
use Core\Database\Redbean\DbConn;
use Core\Database\Redbean\Db;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    DbDriverInterface::class => factory(function (ContainerInterface $c) {
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        // You can change DB driver here
        if ($config->string('db.defaultDbDriver') === 'sqlite') {
            $driver = new DbSqlite($config->string('db.sqlite'));
        } else {
            if ($config->bool('isProduction')) {
                $dbConfig = $config->array('db.prod');
            } else {
                $dbConfig = $config->array('db.dev');
            }
            $driver = new DbSql($dbConfig);
        }
        $driver->setNamespace($config->string('modelNamespace'));
        return $driver;
    }),
    DbConnInterface::class => factory(function (ContainerInterface $c) {
        return new DbConn(
        $c->get(DbDriverInterface::class),
        $c->get(EntificationInterface::class)
        );
    }),
    DbInterface::class => factory(function (ContainerInterface $c) {
        return new Db($c->get(DbConnInterface::class));
    }),
    EntificationSqlInterface::class => factory(function (ContainerInterface $c) {
        return new EntificationSql(
        $c->get(RulesLoaderInterface::class),
        $c->get(DbInterface::class)
        );
    })
];
