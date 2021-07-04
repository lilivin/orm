<?php

require_once 'vendor/autoload.php';

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

$helperSet = new \Symfony\Component\Console\Helper\HelperSet([
	'db' => new Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
	'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
]);

return $helperSet;
