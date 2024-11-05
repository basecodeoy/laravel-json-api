<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi;

use BaseCodeOy\JsonApi\Mixin\RouteMixin;
use BaseCodeOy\JsonApi\Resource\Actions\ResolveRelationshipResource;
use BaseCodeOy\JsonApi\Resource\Actions\ResolveResourceId;
use BaseCodeOy\JsonApi\Resource\Actions\ResolveResourceType;
use BaseCodeOy\JsonApi\Resource\Support\Fields;
use BaseCodeOy\JsonApi\Resource\Support\Includes;
use BaseCodeOy\JsonApi\Server\ServerRepository;
use BaseCodeOy\JsonApi\Server\ServerRepositoryInterface;
use BaseCodeOy\PackagePowerPack\Package\AbstractServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Route;

final class ServiceProvider extends AbstractServiceProvider
{
    public function packageRegistered(): void
    {
        $this->app->singleton(
            ServerRepositoryInterface::class,
            fn (Application $app) => new ServerRepository($app->config->get('json-api.servers')),
        );
    }

    public function packageBooted(): void
    {
        $this->app->singleton(Fields::class);
        $this->app->singleton(Includes::class);

        JsonApi::resolveRelationshipResourceUsing(ResolveRelationshipResource::class);
        JsonApi::resolveResourceIdUsing(ResolveResourceId::class);
        JsonApi::resolveResourceTypeUsing(ResolveResourceType::class);

        $this->bootMixins();
    }

    private function bootMixins(): void
    {
        Route::mixin(new RouteMixin());
    }
}
