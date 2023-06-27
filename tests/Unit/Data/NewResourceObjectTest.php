<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\Attribute;
use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\EmptyRelationship;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\NewResourceObject;
use BombenProdukt\JsonApi\Data\RelatedLink;
use BombenProdukt\JsonApi\Data\ResourceIdentifier;
use BombenProdukt\JsonApi\Data\ResourceIdentifierCollection;
use BombenProdukt\JsonApi\Data\SelfLink;
use BombenProdukt\JsonApi\Data\ToMany;
use BombenProdukt\JsonApi\Data\ToNull;
use BombenProdukt\JsonApi\Data\ToOne;

it('tests full fledged resource object', function (): void {
    expect(
        new DataDocument(
            new NewResourceObject(
                'apples',
                new Meta('foo', 'bar'),
                new Attribute('title', 'Rails is Omakase'),
                new ToNull(
                    'author',
                    new Meta('foo', 'bar'),
                ),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with single id linkage', function (): void {
    expect(
        new DataDocument(
            new NewResourceObject(
                'basket',
                new ToOne('content', new ResourceIdentifier('apples', '1')),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with multi id linkage', function (): void {
    expect(
        new DataDocument(
            new NewResourceObject(
                'basket',
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
            new NewResourceObject(
                'basket',
                new ToMany('content', new ResourceIdentifierCollection()),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests relationship with no data', function (): void {
    expect(
        new DataDocument(
            new NewResourceObject(
                'basket',
                new EmptyRelationship('empty', new RelatedLink('/foo')),
            ),
        ),
    )->toMatchJsonSerialized();

    expect(
        new DataDocument(
            new NewResourceObject(
                'basket',
                new EmptyRelationship('empty', new RelatedLink('/foo'), new SelfLink('/bar'), new Meta('foo', 'bar')),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('ensures resource fields must be unique', function (): void {
    $this->expectException(\LogicException::class);
    $this->expectExceptionMessage("Field 'foo' already exists");
    new NewResourceObject(
        'apples',
        new Attribute('foo', 'bar'),
        new ToOne('foo', new ResourceIdentifier('apples', '1')),
    );
})->throws(\LogicException::class, "Field 'foo' already exists");
