<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework;

use Cspray\AnnotatedContainer\Attribute\ServiceDelegate;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use function FastRoute\simpleDispatcher;

final class Factory {

    #[ServiceDelegate]
    public static function createHandlerRunner(
        Application $application,
        EmitterInterface $emitter
    ) : RequestHandlerRunnerInterface {
        return new RequestHandlerRunner(
            $application,
            $emitter,
            static fn() => ServerRequestFactory::fromGlobals(),
            static fn(\Throwable $error) => new Response(
                body: new CallbackStream(static fn() => 'Internal Server Error'),
                status: 500
            )
        );
    }

    #[ServiceDelegate]
    public static function createEmitter() : EmitterInterface {
        return new SapiEmitter();
    }

    #[ServiceDelegate]
    public static function createRouter(RouterMap $routerMap) : Dispatcher {
        return simpleDispatcher(static function(RouteCollector $routeCollector) use($routerMap) {
            foreach ($routerMap->getRoutes() as $route) {
                $routeCollector->addRoute(
                    $route['method'],
                    $route['path'],
                    $route['handler']
                );
            }
        });
    }

    #[ServiceDelegate]
    public static function createLogger() : LoggerInterface {
        return new Logger(
            'annotated-microframework'
        );
    }

}