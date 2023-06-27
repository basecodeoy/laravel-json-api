<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\NullData;
use BombenProdukt\JsonApi\Data\SelfLink;

it('tests minimal document', function (): void {
    expect(
        new DataDocument(
            new NullData(),
        ),
    )->toMatchJsonSerialized();
});

it('tests extended document', function (): void {
    expect(
        new DataDocument(
            new NullData(),
            new SelfLink('/apples/1'),
            new JsonApi(),
            new Meta('document_meta', 'bar'),
        ),
    )->toMatchJsonSerialized();
});
