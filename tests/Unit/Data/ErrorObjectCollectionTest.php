<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\ErrorObject;
use BaseCodeOy\JsonApi\Data\ErrorObjectCollection;
use BaseCodeOy\JsonApi\Data\ErrorObjectSource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

it('can be created from array', function (): void {
    $errorObject = new ErrorObject();
    $errorObject->setStatus('422');

    $errors = [$errorObject];

    $errorDocument = ErrorObjectCollection::fromArray($errors);

    expect($errorDocument->toArray())->toBe($errors);
});

it('can be created from validator', function (): void {
    $errorMessages = new MessageBag([
        'field' => ['This is an error message.'],
    ]);

    $validator = $this->createMock(Validator::class);
    $validator->method('errors')->willReturn($errorMessages);

    $errorDocument = ErrorObjectCollection::fromValidator($validator);

    $expectedErrors = [
        (new ErrorObject())
            ->setStatus('422')
            ->setDetail('This is an error message.')
            ->setSource((new ErrorObjectSource())->setPointer('/field')),
    ];

    expect($errorDocument->toArray())->toHaveCount(1);
    expect($errorDocument->toArray()[0]->toArray())->toBe($expectedErrors[0]->toArray());
});
