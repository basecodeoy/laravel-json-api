<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\ErrorObjectSource;

it('can be transformed to an array', function (): void {
    $errorObjectSource = new ErrorObjectSource();
    $errorObjectSource->setPointer('/data')
        ->setParameter('id')
        ->setHeader('Content-Type');

    $expectedArray = [
        'pointer' => '/data',
        'parameter' => 'id',
        'header' => 'Content-Type',
    ];

    expect($errorObjectSource->toArray())->toBe($expectedArray);
});
