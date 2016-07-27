<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator();

//$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$parameters = [
	'logDir' => __DIR__ . '/../log',
];
$configurator->addParameters($parameters);

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

return $container;
