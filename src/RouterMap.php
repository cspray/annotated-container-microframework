<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework;

use Cspray\AnnotatedContainer\Attribute\Service;
use Psr\Http\Server\RequestHandlerInterface;

#[Service]
final class RouterMap {

    /**
     * @var list<array{method: string, path: string, handler: RequestHandlerInterface}>
     */
    private array $map = [];

    public function addRoute(string $method, string $path, RequestHandlerInterface $handler) : void {
        $this->map[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * @return list<array{method: string, path: string, handler: RequestHandlerInterface}>
     */
    public function getRoutes() : array {
        return $this->map;
    }

}
