<?php

declare(strict_types=1);

use BombenProdukt\JsonApi\Paginator\LengthAwarePaginator;

return [
    /*
    |--------------------------------------------------------------------------
    | JsonApi Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the namespace for the JsonApi part of your application.
    | This is used whenever a JsonApi class is referenced within the application.
    |
    */
    'namespace_json-api' => 'App\\JsonApi',

    /*
    |--------------------------------------------------------------------------
    | Model Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the namespace for your models. This is used whenever a
    | model is referenced within the application.
    |
    */
    'namespace_model' => 'App\\Models',

    /*
    |--------------------------------------------------------------------------
    | Pagination Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define settings for pagination. This includes the
    | paginator class to be used, default page size, and maximum page size.
    |
    */
    'pagination' => [
        /*
        |--------------------------------------------------------------------------
        | Paginator Class
        |--------------------------------------------------------------------------
        |
        | This value specifies the paginator class to be used. By default, we are
        | using LengthAwarePaginator class.
        |
        */
        'paginator' => LengthAwarePaginator::class,

        /*
        |--------------------------------------------------------------------------
        | Default Page Size
        |--------------------------------------------------------------------------
        |
        | This value sets the default number of items to be displayed per page
        | when using pagination.
        |
        */
        'size_default' => 15,

        /*
        |--------------------------------------------------------------------------
        | Maximum Page Size
        |--------------------------------------------------------------------------
        |
        | This value sets the maximum number of items that can be displayed per page
        | when using pagination.
        |
        */
        'size_maximum' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Servers Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define a list of servers for your application.
    | Each server is represented by its fully qualified class name.
    | Currently, no servers are defined.
    |
    */
    'servers' => [
        // \App\JsonApi\Server\Server::class,
    ],
];
