<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\MetaDocument;

it('ensures JsonApi may contain version and meta', function (): void {
    expect(
        new MetaDocument(
            new Meta('test', 'test'),
            new JsonApi('1.0', new Meta('foo', 'bar')),
        ),
    )->toMatchJsonSerialized();
});
