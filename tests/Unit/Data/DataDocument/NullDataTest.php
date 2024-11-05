<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\JsonApi;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\NullData;
use BaseCodeOy\JsonApi\Data\SelfLink;

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
