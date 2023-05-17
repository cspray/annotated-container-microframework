<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework\Autowire;

use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceGatherer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceWiringObserver;
use Cspray\AnnotatedMicroframework\RouterMap;

final class Observer extends ServiceWiringObserver {

    protected function wireServices(AnnotatedContainer $container, ServiceGatherer $gatherer) : void {
        $routerMap = $container->get(RouterMap::class);
        assert($routerMap instanceof RouterMap);

        foreach ($gatherer->getServicesWithAttribute(Controller::class) as $serviceAndDefinition) {
            $controller = $serviceAndDefinition->getDefinition()->getAttribute();
            assert($controller instanceof Controller);

            $routerMap->addRoute($controller->method, $controller->path, $serviceAndDefinition->getService());
        }
    }
}