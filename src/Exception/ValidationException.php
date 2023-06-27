<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Exception;

use BombenProdukt\JsonApi\Data\ErrorObject;
use BombenProdukt\JsonApi\Data\ErrorObjectCollection;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

final class ValidationException extends Exception implements HttpExceptionInterface, Responsable
{
    public function __construct(
        private readonly ErrorObjectCollection $errors,
        ?Throwable $previous = null,
        private readonly array $headers = [],
    ) {
        parent::__construct('JSON:API error', 422, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function toResponse($request)
    {
        return Response::make(
            [
                'errors' => collect($this->errors->toArray())
                    ->map(fn (ErrorObject $error) => $error->toArray())
                    ->values()
                    ->toArray(),
            ],
            $this->getStatusCode(),
            $this->getHeaders(),
        );
    }
}
