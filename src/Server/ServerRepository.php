<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Server;

use BaseCodeOy\JsonApi\Route\RouteParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use RuntimeException;

final class ServerRepository implements ServerRepositoryInterface
{
    private Collection $servers;

    public function __construct(array $servers)
    {
        $this->servers = new Collection();

        foreach ($servers as $server) {
            $this->register($server);
        }
    }

    /**
     * @return Collection<int, ServerInterface>
     */
    public function all(): Collection
    {
        return $this->servers;
    }

    public function findByVersion(string $version): ServerInterface
    {
        return $this->servers->get($version, fn () => throw new RuntimeException('Server not found'));
    }

    public function findByRequest(Request $request): ServerInterface
    {
        return $this->findByVersion($request->route()->parameter(RouteParameter::API_VERSION));
    }

    public function register(string|ServerInterface $server): void
    {
        if (\is_string($server)) {
            $server = App::make($server);
        }

        $this->servers[$server->getVersion()] = $server;
    }
}
