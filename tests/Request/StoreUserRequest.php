<?php

declare(strict_types=1);

namespace Tests\Request;

use BombenProdukt\JsonApi\Http\Request\AbstractFormRequest;

final class StoreUserRequest extends AbstractFormRequest
{
    protected function rulesForAttributes(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'email_verified_at' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
