<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Entity;

use BombenProdukt\JsonApi\Entity\Relations\RelationInterface;
use BombenProdukt\JsonApi\Entity\Relations\RelationRepository;
use BombenProdukt\JsonApi\Server\ServerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractEntity implements EntityInterface
{
    private readonly RelationRepository $relationRepository;

    public function __construct(private readonly ServerInterface $server)
    {
        $this->relationRepository = new RelationRepository($this->getRelations());
    }

    /**
     * @return string[]
     */
    public function allowedFields(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function allowedFilters(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function allowedIncludes(): array
    {
        return $this->getRelations();
    }

    /**
     * @return string[]
     */
    public function allowedSorts(): array
    {
        return [];
    }

    public function getStoreFormRequest(): ?string
    {
        return null;
    }

    public function getUpdateFormRequest(): ?string
    {
        return null;
    }

    /**
     * @return array<string, RelationInterface>
     */
    public function getRelations(): array
    {
        return [];
    }

    public function getRelationRepository(): RelationRepository
    {
        return $this->relationRepository;
    }

    public function getModel(): string
    {
        return Str::of(class_basename($this))
            ->before('Entity')
            ->singular()
            ->studly()
            ->prepend(Config::get('json-api.namespace_model').'\\')
            ->toString();
    }

    public function getModelName(): string
    {
        return class_basename($this->getModel());
    }

    public function getResource(): string
    {
        return Str::of($this->getModelName())
            ->prepend(Config::get('json-api.namespace_json-api').'\\Resource\\')
            ->append('Resource')
            ->toString();
    }

    public function getResourceType(): string
    {
        return Str::of($this->getModelName())
            ->plural()
            ->kebab()
            ->toString();
    }

    public function getResourceName(): string
    {
        return Str::of($this->getModelName())
            ->singular()
            ->kebab()
            ->toString();
    }

    public function getPaginator(): string
    {
        return Config::get('json-api.pagination.paginator');
    }

    public function getServer(): ServerInterface
    {
        return $this->server;
    }

    public function toResource(mixed $data): JsonResource
    {
        return $this->getResource()::make($data);
    }

    public function toCollection(mixed $data): AnonymousResourceCollection
    {
        return $this->getResource()::collection($data);
    }

    public function toQueryBuilder(Request $request): QueryBuilder
    {
        $builder = QueryBuilder::for($this->getModel(), $request);

        $allowedFields = $this->allowedFields();

        if (\count($allowedFields) > 0) {
            $builder->allowedFields($allowedFields);
        }

        $allowedFilters = $this->allowedFilters();

        if (\count($allowedFilters) > 0) {
            $builder->allowedFilters($allowedFilters);
        }

        // $allowedIncludes = $this->allowedIncludes();

        // if (\count($allowedIncludes) > 0) {
        //     $builder->allowedIncludes($allowedIncludes);
        // }

        $allowedSorts = $this->allowedSorts();

        if (\count($allowedSorts) > 0) {
            $builder->allowedSorts($allowedSorts);
        }

        return $builder;
    }
}
