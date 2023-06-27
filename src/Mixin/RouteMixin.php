<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Mixin;

use BombenProdukt\JsonApi\Route\PendingServerRegistration;
use BombenProdukt\JsonApi\Server\ServerInterface;
use Closure;
use Illuminate\Support\Facades\App;

final class RouteMixin
{
    public function jsonapi(): Closure
    {
        /**
         * @param class-string<ServerInterface> $server
         */
        return fn (string $server): PendingServerRegistration => App::make(
            PendingServerRegistration::class,
            [
                'server' => App::make($server),
            ],
        );
    }
}
