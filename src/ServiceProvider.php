<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi;

use BombenProdukt\JsonApi\Mixin\RouteMixin;
use BombenProdukt\JsonApi\Resource\Actions\ResolveRelationshipResource;
use BombenProdukt\JsonApi\Resource\Actions\ResolveResourceId;
use BombenProdukt\JsonApi\Resource\Actions\ResolveResourceType;
use BombenProdukt\JsonApi\Resource\Support\Fields;
use BombenProdukt\JsonApi\Resource\Support\Includes;
use BombenProdukt\JsonApi\Server\ServerRepository;
use BombenProdukt\JsonApi\Server\ServerRepositoryInterface;
use BombenProdukt\PackagePowerPack\Package\AbstractServiceProvider;
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
