<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\ResourceIdentifier;
use BombenProdukt\JsonApi\Data\SelfLink;

it('ensures a link object behaves as expected', function (): void {
    expect(
        new DataDocument(
            new ResourceIdentifier('apples', '1'),
            new SelfLink('http://example.com', new Meta('foo', 'bar'), new Meta('test', true)),
        ),
    )->toMatchJsonSerialized();
});
