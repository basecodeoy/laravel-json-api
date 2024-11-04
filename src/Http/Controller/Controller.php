<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Http\Controller;

use BaseCodeOy\JsonApi\Entity\EntityInterface;
use BaseCodeOy\JsonApi\Route\CurrentRoute;
use BaseCodeOy\JsonApi\Server\ServerInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Traits\Macroable;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use Macroable;
    use ValidatesRequests;

    protected mixed $response = null;

    protected function resolveEntity(ServerInterface $server, ?string $type = null): EntityInterface
    {
        return $server
            ->getEntityRepository()
            ->findByResourceType($type ?? CurrentRoute::getResourceType());
    }

    protected function resolveRelationship(): string
    {
        return CurrentRoute::getResourceRelationship();
    }

    protected function resolveResourceModel(): Model
    {
        return CurrentRoute::getModel();
    }

    protected function callWhenPresent(string $method, Request $request, ServerInterface $server, EntityInterface $entity): bool
    {
        if (\method_exists($this, $method)) {
            $this->response = $this->{$method}($request, $server, $entity);
        }

        return $this->response !== null;
    }

    protected function noContent(): Response
    {
        return ResponseFacade::noContent();
    }
}
