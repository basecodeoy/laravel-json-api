<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Http\Middleware;

use BombenProdukt\JsonApi\Entity\EntityInterface;
use BombenProdukt\JsonApi\Paginator\PaginatorInterface;
use BombenProdukt\JsonApi\Route\Route;
use BombenProdukt\JsonApi\Route\RouteParameter;
use BombenProdukt\JsonApi\Route\RouterInterface;
use BombenProdukt\JsonApi\Server\ServerInterface;
use BombenProdukt\JsonApi\Server\ServerRepositoryInterface;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

final readonly class BootJsonApiMiddleware
{
    public function __construct(
        private Container $container,
        private ServerRepositoryInterface $serverRepository,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $this->container->instance(
            ServerInterface::class,
            $server = $this->serverRepository->findByRequest($request),
        );

        $this->container->instance(
            EntityInterface::class,
            $entity = $server->getEntityRepository()->findByResourceType($request->route()->parameter(RouteParameter::RESOURCE_TYPE)),
        );

        $this->container->instance(
            RouterInterface::class,
            $route = new Route($request->route()),
        );

        $route->substituteBindings();

        $this->registerPaginator($entity);

        return $next($request);
    }

    public function terminate(): void
    {
        $this->container->forgetInstance(ServerInterface::class);
    }

    private function registerPaginator(EntityInterface $entity): void
    {
        /**
         * @var PaginatorInterface $paginator
         */
        $paginator = App::make($entity->getPaginator());
        $paginator = $paginator->register();

        EloquentBuilder::macro('jsonPaginate', $paginator);
        BaseBuilder::macro('jsonPaginate', $paginator);

        BelongsToMany::macro('jsonPaginate', $paginator);
        HasManyThrough::macro('jsonPaginate', $paginator);
    }
}
