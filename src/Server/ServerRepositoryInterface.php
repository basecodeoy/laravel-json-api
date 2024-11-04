<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Server;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ServerRepositoryInterface
{
    /**
     * @return Collection<int, ServerInterface>
     */
    public function all(): Collection;

    public function findByVersion(string $version): ServerInterface;

    public function findByRequest(Request $request): ServerInterface;

    public function register(ServerInterface $server): void;
}
