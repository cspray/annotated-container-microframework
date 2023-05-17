<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$bootstrap = new \Cspray\AnnotatedContainer\Bootstrap\Bootstrap();
$container = $bootstrap->bootstrapContainer();

$handlerRunner = $container->get(\Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface::class);
$handlerRunner->run();