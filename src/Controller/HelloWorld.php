<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework\Controller;

use Cspray\AnnotatedMicroframework\Autowire\Controller;
use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[Controller('GET', '/hello/{who}')]
final class HelloWorld implements RequestHandlerInterface {

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        $who = $request->getAttribute('who');

        return new Response(
            body: new CallbackStream(static fn() => 'Hello, '. $who . '!')
        );
    }
}