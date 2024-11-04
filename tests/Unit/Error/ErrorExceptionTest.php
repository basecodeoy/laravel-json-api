<?php

declare(strict_types=1);

namespace Tests\Unit\Error;

use BaseCodeOy\JsonApi\Data\ErrorObject;
use BaseCodeOy\JsonApi\Data\ErrorObjectCollection;
use BaseCodeOy\JsonApi\Exception\ValidationException;
use Illuminate\Support\Facades\Response;

it('gets the correct status code', function (): void {
    $errorDocument = ErrorObjectCollection::fromArray([
        (new ErrorObject())
            ->setStatus('422')
            ->setDetail('This is an error message.'),
    ]);

    $errorException = new ValidationException($errorDocument);

    expect($errorException->getStatusCode())->toBe(422);
});

it('gets the correct headers', function (): void {
    $headers = ['Content-Type' => 'application/json'];

    $errorDocument = ErrorObjectCollection::fromArray([
        (new ErrorObject())
            ->setStatus('422')
            ->setDetail('This is an error message.'),
    ]);

    $errorException = new ValidationException($errorDocument, null, $headers);

    expect($errorException->getHeaders())->toBe($headers);
});

it('creates a correct response', function (): void {
    $headers = ['Content-Type' => 'application/json'];

    $errorDocument = ErrorObjectCollection::fromArray([
        $errorObject = (new ErrorObject())
            ->setStatus('422')
            ->setDetail('This is an error message.'),
    ]);

    $errorException = new ValidationException($errorDocument, null, $headers);

    Response::shouldReceive('make')
        ->once()
        ->with(
            ['errors' => [$errorObject->toArray()]],
            422,
            $headers,
        );

    $errorException->toResponse(null);
});
