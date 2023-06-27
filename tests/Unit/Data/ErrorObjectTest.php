<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\ErrorObject;
use BombenProdukt\JsonApi\Data\ErrorObjectLinks;
use BombenProdukt\JsonApi\Data\ErrorObjectSource;

it('can be transformed to an array', function (): void {
    $errorObjectLinks = new ErrorObjectLinks();
    $errorObjectLinks->setAbout('https://example.com');

    $errorObjectSource = new ErrorObjectSource();
    $errorObjectSource->setPointer('/data');

    $errorObject = new ErrorObject();
    $errorObject->setId('1')
        ->setLinks($errorObjectLinks)
        ->setStatus('422')
        ->setCode('error_code')
        ->setTitle('Test Error')
        ->setDetail('This is a test error')
        ->setSource($errorObjectSource)
        ->setMeta(['key' => 'value']);

    $expectedArray = [
        'id' => '1',
        'links' => ['about' => 'https://example.com'],
        'status' => '422',
        'code' => 'error_code',
        'title' => 'Test Error',
        'detail' => 'This is a test error',
        'source' => ['pointer' => '/data'],
        'meta' => ['key' => 'value'],
    ];

    expect($errorObject->toArray())->toBe($expectedArray);
});
