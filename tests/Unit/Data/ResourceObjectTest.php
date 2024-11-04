<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\Attribute;
use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\EmptyRelationship;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\RelatedLink;
use BaseCodeOy\JsonApi\Data\ResourceIdentifier;
use BaseCodeOy\JsonApi\Data\ResourceIdentifierCollection;
use BaseCodeOy\JsonApi\Data\ResourceObject;
use BaseCodeOy\JsonApi\Data\SelfLink;
use BaseCodeOy\JsonApi\Data\ToMany;
use BaseCodeOy\JsonApi\Data\ToNull;
use BaseCodeOy\JsonApi\Data\ToOne;

it('tests full fledged resource object', function (): void {
    expect(
        new DataDocument(
            new ResourceObject(
                'apples',
                '1',
                new Meta('foo', 'bar'),
                new Attribute('title', 'Rails is Omakase'),
                new SelfLink('http://self'),
                new ToNull(
                    'author',
                    new Meta('foo', 'bar'),
                    new SelfLink('http://rel/author'),
                    new RelatedLink('http://author'),
                ),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with single id linkage', function (): void {
    expect(
        new DataDocument(
            new ResourceObject(
                'basket',
                '1',
                new ToOne('content', new ResourceIdentifier('apples', '1')),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with multi id linkage', function (): void {
    expect(
        new DataDocument(
            new ResourceObject(
                'basket',
                '1',
                new ToMany(
                    'content',
                    new ResourceIdentifierCollection(
                        new ResourceIdentifier('apples', '1'),
                        new ResourceIdentifier('pears', '2'),
                    ),
                ),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with empty multi id linkage', function (): void {
    expect(
        new DataDocument(
            new ResourceObject(
                'basket',
                '1',
                new ToMany('content', new ResourceIdentifierCollection()),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with no data', function (): void {
    expect(
        new DataDocument(
            new ResourceObject(
                'basket',
                '1',
                new EmptyRelationship('empty', new RelatedLink('/foo')),
            ),
        ),
    )->toMatchJsonSerialized();

    expect(
        new DataDocument(
            new ResourceObject(
                'basket',
                '1',
                new EmptyRelationship('empty', new RelatedLink('/foo'), new SelfLink('/bar'), new Meta('foo', 'bar')),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('ensures resource fields must be unique', function (): void {
    $this->expectException(\LogicException::class);
    $this->expectExceptionMessage("Field 'foo' already exists");
    new ResourceObject(
        'apples',
        '1',
        new Attribute('foo', 'bar'),
        new ToOne('foo', new ResourceIdentifier('apples', '1')),
    );
})->throws(\LogicException::class, "Field 'foo' already exists");
