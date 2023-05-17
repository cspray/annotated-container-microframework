<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework;

use Cspray\AnnotatedContainer\Attribute\Service;
use FastRoute\Dispatcher;
use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

#[Service]
final class Application implements RequestHandlerInterface {

    public function __construct(
        private readonly Dispatcher $router,
        private readonly LoggerInterface $logger
    ) {}

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $this->logger->info(sprintf(
            'Routing method: %s and path: %s',
            $method,
            $path
        ));

        $routeInfo = $this->router->dispatch($method, $path);

        $status = array_shift($routeInfo);
        if ($status === Dispatcher::NOT_FOUND) {
            return new Response(
                body: new CallbackStream(static fn() => 'Not Found'),
                status: 404
            );
        } else if ($status === Dispatcher::METHOD_NOT_ALLOWED) {
            return new Response(
                body: new CallbackStream(static fn() => 'Method Not Allowed'),
                status: 405
            );
        } else {
            $handler = array_shift($routeInfo);
            assert($handler instanceof RequestHandlerInterface);

            $params = array_shift($routeInfo);
            foreach ($params as $key => $val) {
                $request = $request->withAttribute($key, $val);
            }

            return $handler->handle($request);
        }
    }
}