<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Http\Request;

use BaseCodeOy\JsonApi\Entity\Entity;
use BaseCodeOy\JsonApi\Entity\Relations\RelationInterface;
use BaseCodeOy\JsonApi\Route\CurrentRoute;
use Illuminate\Http\Request;

final class ResourceRequest extends AbstractFormRequest
{
    public static function for(Request $request): self
    {
        $request = self::createFrom($request);
        $request->validateJsonApi();

        return $request;
    }

    public function isToOne(): bool
    {
        return $this->getRelation()->isToOne();
    }

    public function isToMany(): bool
    {
        return $this->getRelation()->isToMany();
    }

    public function validateJsonApi(): array
    {
        return $this->validate($this->rules());
    }

    public function getRelation(): RelationInterface
    {
        return Entity::getRelationRepository()->findByName(CurrentRoute::getResourceRelationship());
    }
}
