<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use Illuminate\Routing\RouteCollection;

final class Relationships
{
    /**
     * @var array<string, PendingRelationshipRegistration>
     */
    private array $relationships = [];

    public function __construct(private readonly RelationshipRegistrar $registrar) {}

    public function belongsTo(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasOne($relationship, $controller);
    }

    public function belongsToMany(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasMany($relationship, $controller);
    }

    public function hasMany(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->relationships[$relationship] = new PendingRelationshipRegistration(
            $this->registrar,
            $relationship,
            $controller,
            true,
        );
    }

    public function hasManyThrough(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasMany($relationship, $controller);
    }

    public function hasOne(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->relationships[$relationship] = new PendingRelationshipRegistration(
            $this->registrar,
            $relationship,
            $controller,
            false,
        );
    }

    public function hasOneThrough(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasOne($relationship, $controller);
    }

    public function morphOne(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasOne($relationship, $controller);
    }

    public function morphMany(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasMany($relationship, $controller);
    }

    public function morphTo(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasOne($relationship, $controller);
    }

    public function morphToMany(string $relationship, ?string $controller = null): PendingRelationshipRegistration
    {
        return $this->hasMany($relationship, $controller);
    }

    public function register(): RouteCollection
    {
        $routes = new RouteCollection();

        foreach ($this->relationships as $registration) {
            foreach ($registration->register() as $route) {
                $routes->add($route);
            }
        }

        return $routes;
    }
}
