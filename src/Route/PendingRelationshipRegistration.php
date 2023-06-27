<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use BombenProdukt\JsonApi\Http\Controller\RelationshipController;
use Illuminate\Routing\RouteCollection;

final class PendingRelationshipRegistration
{
    protected bool $registered = false;

    public function __construct(
        private readonly RelationshipRegistrar $registrar,
        private readonly string $relationship,
        private readonly ?string $controller,
        private readonly bool $hasMany,
    ) {}

    public function register(): RouteCollection
    {
        $this->registered = true;

        return $this->registrar->register(
            $this->relationship,
            $this->controller ?? RelationshipController::class,
            $this->hasMany,
        );
    }
}
