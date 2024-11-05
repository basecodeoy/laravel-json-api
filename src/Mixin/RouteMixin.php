<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Mixin;

use BaseCodeOy\JsonApi\Route\PendingServerRegistration;
use BaseCodeOy\JsonApi\Server\ServerInterface;
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
