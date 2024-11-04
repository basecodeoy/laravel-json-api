<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Entity;

use BaseCodeOy\JsonApi\Entity\Relations\RelationInterface;
use BaseCodeOy\JsonApi\Entity\Relations\RelationRepository;
use BaseCodeOy\JsonApi\Server\ServerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

interface EntityInterface
{
    /**
     * @see https://jsonapi.org/format/#fetching-sparse-fieldsets
     */
    public function allowedFields(): array;

    /**
     * @see https://jsonapi.org/format/#fetching-filtering
     */
    public function allowedFilters(): array;

    /**
     * @see https://jsonapi.org/format/#fetching-includes
     */
    public function allowedIncludes(): array;

    /**
     * @see https://jsonapi.org/format/#fetching-sorting
     */
    public function allowedSorts(): array;

    /**
     * The FQCN of the form request class that validates the `store` request.
     *
     * @example App\Http\Requests\StorePostRequest
     */
    public function getStoreFormRequest(): ?string;

    /**
     * The FQCN of the form request class that validates the `update` request.
     *
     * @example App\Http\Requests\UpdatePostRequest
     */
    public function getUpdateFormRequest(): ?string;

    /**
     * @return array<string, RelationInterface>
     */
    public function getRelations(): array;

    public function getRelationRepository(): RelationRepository;

    /**
     * The FQCN of the model.
     *
     * @example BaseCodeOy\JsonApi\Models\Post
     */
    public function getModel(): string;

    /**
     * The name of the model.
     *
     * @example Post
     */
    public function getModelName(): string;

    /**
     * The FQCN of the resource.
     *
     * @example BaseCodeOy\JsonApi\Resource\PostResource
     */
    public function getResource(): string;

    /**
     * The type of the resource.
     *
     * @example posts
     */
    public function getResourceType(): string;

    /**
     * The name of the resource.
     *
     * @example post
     */
    public function getResourceName(): string;

    /**
     * The FQCN of the paginator.
     *
     * @example BaseCodeOy\JsonApi\Paginator\LengthAwarePaginator
     */
    public function getPaginator(): string;

    /**
     * The server that is responsible for this entity.
     */
    public function getServer(): ServerInterface;

    /**
     * Transform the data into a resource.
     */
    public function toResource(mixed $data): JsonResource;

    /**
     * Transform the data into a collection of resources.
     */
    public function toCollection(mixed $data): AnonymousResourceCollection;

    /**
     * Create a JSON:API query builder.
     */
    public function toQueryBuilder(Request $request): QueryBuilder;
}
