<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Http\Controller;

use BombenProdukt\JsonApi\Entity\EntityInterface;
use BombenProdukt\JsonApi\Http\Request\ResourceRequest;
use BombenProdukt\JsonApi\Server\Server;
use BombenProdukt\JsonApi\Server\ServerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

final class RelationshipController extends Controller
{
    public function index(Request $request, ServerInterface $server, EntityInterface $entity): AnonymousResourceCollection
    {
        if (Server::shouldAuthorize($entity)) {
            $this->authorize('viewAny', [
                $entity->getModel(),
                $this->resolveEntity($server, $this->resolveRelationship())->getModel(),
            ]);
        }

        if ($this->callWhenPresent('reading', $request, $server, $entity)) {
            return $this->response;
        }

        $models = QueryBuilder::for(
            $this
                ->resolveResourceModel()
                ->{$this->resolveRelationship()}(),
        )->jsonPaginate();

        if ($this->callWhenPresent('read', $request, $server, $entity)) {
            return $this->response;
        }

        return $this
            ->resolveEntity($server, $this->resolveRelationship())
            ->toCollection($models);
    }

    public function store(Request $request, ServerInterface $server, EntityInterface $entity): Response
    {
        $request = ResourceRequest::for($request);
        $relation = $request->getRelation();

        if ($this->callWhenPresent('storing', $request, $server, $entity)) {
            return $this->response;
        }

        $model = $this->resolveResourceModel();

        if (Server::shouldAuthorize($entity)) {
            $this->authorize('create', [
                $model,
                $this->resolveEntity($server, $this->resolveRelationship())->getModel(),
            ]);
        }

        $server->getEloquentRepository()->attach(
            $model,
            $relation->getName(),
            collect($request->get('data'))->pluck('id')->toArray(),
        );

        if ($this->callWhenPresent('stored', $request, $server, $entity)) {
            return $this->response;
        }

        return $this->noContent();
    }

    public function update(Request $request, ServerInterface $server, EntityInterface $entity): Response
    {
        $request = ResourceRequest::for($request);
        $relation = $request->getRelation();

        if ($this->callWhenPresent('updating', $request, $server, $entity)) {
            return $this->response;
        }

        $model = $this->resolveResourceModel();

        if (Server::shouldAuthorize($entity)) {
            $this->authorize('update', [$model, $relation->getName()]);
        }

        if ($relation->isToOne()) {
            $server->getEloquentRepository()->associate(
                $model,
                $relation->getName(),
                $server->getEloquentRepository()->findOrFail($request->input('data.type'), $request->input('data.id')),
            );
        } else {
            $server->getEloquentRepository()->sync(
                $model,
                $relation->getName(),
                collect($request->get('data'))->pluck('id')->toArray(),
            );
        }

        if ($this->callWhenPresent('updated', $request, $server, $entity)) {
            return $this->response;
        }

        return $this->noContent();
    }

    public function destroy(Request $request, ServerInterface $server, EntityInterface $entity): Response
    {
        $request = ResourceRequest::for($request);
        $relation = $request->getRelation();

        if ($this->callWhenPresent('destroying', $request, $server, $entity)) {
            return $this->response;
        }

        $model = $this->resolveResourceModel();

        if (Server::shouldAuthorize($entity)) {
            $this->authorize('delete', [$model, $relation->getName()]);
        }

        $server->getEloquentRepository()->detach(
            $model,
            $relation->getName(),
            collect($request->get('data'))->pluck('id')->toArray(),
        );

        if ($this->callWhenPresent('destroyed', $request, $server, $entity)) {
            return $this->response;
        }

        return $this->noContent();
    }
}
