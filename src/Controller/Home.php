<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework\Controller;

use Cspray\AnnotatedMicroframework\Autowire\Controller;
use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[Controller('GET', '/')]
class Home implements RequestHandlerInterface {

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        return new Response(
            body: new CallbackStream(static fn() => 'Home Page')
        );
    }

}