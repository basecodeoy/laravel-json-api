<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\JsonApi;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\MetaDocument;

it('ensures a valid document may contain just a meta object', function (): void {
    expect(new MetaDocument(new Meta('foo', 'bar')))
        ->toMatchJsonSerialized();
});

it('ensures a meta document may contain jsonapi member', function (): void {
    expect(new MetaDocument(new Meta('foo', 'bar'), new JsonApi()))
        ->toMatchJsonSerialized();
});
