<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

use BaseCodeOy\JsonApi\Resource\Model\Link;
use BaseCodeOy\JsonApi\Resource\Model\RelationshipLink;
use BaseCodeOy\JsonApi\Server\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasRelationshipLinks
{
    public function toRelationshipLink(Request $request, JsonResource $parent, string $relationship): RelationshipLink
    {
        return RelationshipLink::toOne(
            $this->toResourceIdentifier($request),
            [
                $this->toSelfLinkWithRelationship($parent, $relationship),
                $this->toRelatedLinkWithRelationship($parent, $relationship),
            ],
        );
    }

    public function toSelfLink(): Link
    {
        return Link::self(
            route(
                \sprintf(
                    'api.%s.%s.show',
                    Server::getVersion(),
                    $this->resource->getTable(),
                ),
                $this->resource,
            ),
        );
    }

    public function toSelfLinkWithRelationship(JsonResource $parent, string $relationship): Link
    {
        return Link::self(
            route(
                \sprintf(
                    'api.%s.%s.%s',
                    Server::getVersion(),
                    $parent->resource->getTable(),
                    $relationship,
                ),
                $this->resource,
            ),
        );
    }

    public function toRelatedLink(): Link
    {
        return Link::related(
            route(
                \sprintf(
                    'api.%s.%s.index',
                    Server::getVersion(),
                    $this->resource->getTable(),
                ),
                $this->resource,
            ),
        );
    }

    public function toRelatedLinkWithRelationship(JsonResource $parent, string $relationship): Link
    {
        return Link::related(
            route(
                \sprintf(
                    'api.%s.%s.%s.index',
                    Server::getVersion(),
                    $parent->resource->getTable(),
                    $relationship,
                ),
                $this->resource,
            ),
        );
    }
}
