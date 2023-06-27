<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use JsonSerializable;

final readonly class ErrorObjectCollection implements JsonSerializable, MemberInterface
{
    /**
     * @param ErrorObject[] $errors
     */
    private readonly array $errors;

    public function __construct(ErrorObject ...$errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param ErrorObject[] $errors
     */
    public static function fromArray(array $errors): self
    {
        return new self(...$errors);
    }

    public static function fromValidator(Validator $validator): self
    {
        $errors = [];

        foreach ($validator->errors()->messages() as $field => $messages) {
            $error = new ErrorObject();
            $error->setStatus(422);
            $error->setDetail(\implode('|', $messages));
            $error->setSource(new ErrorObjectSource(pointer: Str::of($field)->replace('.', '/')->prepend('/')->toString()));

            $errors[] = $error;
        }

        return new self(...$errors);
    }

    public function toArray(): array
    {
        return $this->errors;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function attachTo(array $data): array
    {
        $data['errors'] = $this->toArray();

        return $data;
    }
}
