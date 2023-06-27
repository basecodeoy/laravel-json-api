<?php

declare(strict_types=1);

namespace Tests\Request;

use BombenProdukt\JsonApi\Http\Request\AbstractFormRequest;

final class UpdateUserRequest extends AbstractFormRequest
{
    protected function rulesForAttributes(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'email_verified_at' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
        ];
    }
}
