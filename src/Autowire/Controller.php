<?php declare(strict_types=1);

namespace Cspray\AnnotatedMicroframework\Autowire;

use Attribute;
use Cspray\AnnotatedContainer\Attribute\ServiceAttribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Controller implements ServiceAttribute {

    public function __construct(
        public readonly string $method,
        public readonly string $path
    ) {}

    public function getProfiles() : array {
        return [];
    }

    public function isPrimary() : bool {
        return false;
    }

    public function getName() : ?string {
        return null;
    }
}