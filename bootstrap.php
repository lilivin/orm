<?php

require_once "vendor/autoload.php";

$path = __DIR__;
$isDevMode = true;
$config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration([$path . '/xml'], $isDevMode);

$connectionOptions = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'port' => '3306',
    'dbname' => 'nieruchomosci',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8'
];

$em = Doctrine\ORM\EntityManager::create($connectionOptions, $config);