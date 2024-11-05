<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\ResourceIdentifier;
use BaseCodeOy\JsonApi\Data\SelfLink;

it('ensures a link object behaves as expected', function (): void {
    expect(
        new DataDocument(
            new ResourceIdentifier('apples', '1'),
            new SelfLink('http://example.com', new Meta('foo', 'bar'), new Meta('test', true)),
        ),
    )->toMatchJsonSerialized();
});
