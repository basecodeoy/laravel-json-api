<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Http\Controller;

use BaseCodeOy\JsonApi\Entity\EntityInterface;
use BaseCodeOy\JsonApi\Http\Request\AbstractFormRequest;
use BaseCodeOy\JsonApi\Server\Server;
use BaseCodeOy\JsonApi\Server\ServerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

final class ResourceController extends Controller
{
    public function index(Request $request, ServerInterface $server, EntityInterface $entity): AnonymousResourceCollection
    {
        if (Server::shouldAuthorize($entity)) {
            $this->authorize('viewAny', $entity->getModel());
        }

        if ($this->callWhenPresent('searching', $request, $server, $entity)) {
            return $this->response;
        }

        $models = $entity
            ->toQueryBuilder($request)
            ->jsonPaginate()
            ->appends($request->query());

        if ($this->callWhenPresent('searched', $request, $server, $entity)) {
            return $this->response;
        }

        return $entity->toCollection($models);
    }

    public function store(Request $request, ServerInterface $server, EntityInterface $entity): JsonResource
    {
        if (Server::shouldAuthorize($entity)) {
            $this->authorize('create', $entity->getModel());
        }

        if ($this->callWhenPresent('storing', $request, $server, $entity)) {
            return $this->response;
        }

        if (\is_string($entity->getStoreFormRequest())) {
            /**
             * @var AbstractFormRequest $request
             */
            $request = App::make($entity->getStoreFormRequest());

            $model = $server->getEloquentRepository()->create($entity, $request->getAttributes());
        } else {
            $model = $entity->getModel()::create($request->all());
        }

        if ($this->callWhenPresent('stored', $request, $server, $entity)) {
            return $this->response;
        }

        return $entity->toResource($model);
    }

    public function show(Request $request, ServerInterface $server, EntityInterface $entity): JsonResource
    {
        if ($this->callWhenPresent('reading', $request, $server, $entity)) {
            return $this->response;
        }

        $model = $this->resolveResourceModel();

        if (Server::shouldAuthorize($entity)) {
            $this->authorize('view', $model);
        }

        if ($this->callWhenPresent('read', $request, $server, $entity)) {
            return $this->response;
        }

        return $entity->toResource($model);
    }

    public function update(Request $request, ServerInterface $server, EntityInterface $entity): JsonResource
    {
        if ($this->callWhenPresent('updating', $request, $server, $entity)) {
            return $this->response;
        }

        $model = $this->resolveResourceModel();

        if (Server::shouldAuthorize($entity)) {
            $this->authorize('update', $model);
        }

        if (\is_string($entity->getUpdateFormRequest())) {
            /**
             * @var AbstractFormRequest $request
             */
            $request = App::make($entity->getUpdateFormRequest());

            $server->getEloquentRepository()->update($model, $request->getAttributes());
        } else {
            $model->update($request->all());
        }

        if ($this->callWhenPresent('updated', $request, $server, $entity)) {
            return $this->response;
        }

        return $entity->toResource($model->fresh());
    }

    public function destroy(Request $request, ServerInterface $server, EntityInterface $entity): Response
    {
        if ($this->callWhenPresent('destroying', $request, $server, $entity)) {
            return $this->response;
        }

        $model = $this->resolveResourceModel();

        if (Server::shouldAuthorize($entity)) {
            $this->authorize('delete', $model);
        }

        $server->getEloquentRepository()->delete($model);

        if ($this->callWhenPresent('destroyed', $request, $server, $entity)) {
            return $this->response;
        }

        return $this->noContent();
    }
}
