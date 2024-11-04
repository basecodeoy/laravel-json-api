<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\ErrorObjectLinks;

it('can be transformed to an array', function (): void {
    $errorObjectLinks = new ErrorObjectLinks();
    $errorObjectLinks->setAbout('https://example.com')
        ->setType('test_type');

    $expectedArray = [
        'about' => 'https://example.com',
        'type' => 'test_type',
    ];

    expect($errorObjectLinks->toArray())->toBe($expectedArray);
});
