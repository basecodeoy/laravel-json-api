<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\ErrorDocument;
use BombenProdukt\JsonApi\Data\ErrorObject;
use BombenProdukt\JsonApi\Data\ErrorObjectCollection;
use BombenProdukt\JsonApi\Data\ErrorObjectLinks;
use BombenProdukt\JsonApi\Data\ErrorObjectSource;
use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;

it('tests minimal example', function (): void {
    expect(
        new ErrorDocument(
            new ErrorObjectCollection(
                new ErrorObject(),
            ),
        ),
    )->toMatchJsonSerialized();
});

it('tests extensive example', function (): void {
    $document = new ErrorDocument(
        new ErrorObjectCollection(
            new ErrorObject(
                id: '1',
                status: '404',
                code: 'not_found',
                title: 'Resource not found',
                detail: 'We tried hard but could not find anything',
                source: new ErrorObjectSource('/data', 'query_string'),
                links: new ErrorObjectLinks(
                    about: '/errors/not_found',
                ),
            ),
        ),
    );
    $document->addMember(new JsonApi());
    $document->addMember(new Meta('purpose', 'test'));

    expect($document)->toMatchJsonSerialized();
});

it('tests multiple errors', function (): void {
    expect(
        new ErrorDocument(
            new ErrorObjectCollection(
                new ErrorObject(
                    id: '1',
                    code: 'invalid_parameter',
                    source: new ErrorObjectSource(parameter: 'foo'),
                ),
                new ErrorObject(
                    id: '2',
                    code: 'invalid_parameter',
                    source: new ErrorObjectSource(parameter: 'bar'),
                ),
            ),
        ),
    )->toMatchJsonSerialized();
});
