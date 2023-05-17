<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework\Autowire;

use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProvider as AnnotatedContainerDefinitionProvider;
use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProviderContext;
use FastRoute\Dispatcher;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Psr\Log\LoggerInterface;
use function Cspray\AnnotatedContainer\service;
use function Cspray\Typiphy\objectType;

final class DefinitionProvider implements AnnotatedContainerDefinitionProvider {

    public function consume(DefinitionProviderContext $context) : void {
        service($context, objectType(RequestHandlerRunnerInterface::class));
        service($context, objectType(EmitterInterface::class));
        service($context, objectType(Dispatcher::class));
        service($context, objectType(LoggerInterface::class));
    }
}