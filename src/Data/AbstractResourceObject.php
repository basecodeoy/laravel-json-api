<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use LogicException;

abstract class AbstractResourceObject implements MemberInterface
{
    protected array $data;

    protected array $registry = [];

    public function __construct(protected string $type, MemberInterface ...$members)
    {
        $this->data = ['type' => $type];

        $this->addMembers(...$members);
    }

    public function attachTo(array $data): array
    {
        $data['data'] = $this->data;

        return $data;
    }

    protected function addMembers(MemberInterface ...$members): void
    {
        $fields = [];

        foreach ($members as $member) {
            if ($member instanceof ResourceField) {
                $name = $member->name();

                if (isset($fields[$name])) {
                    throw new LogicException("Field '{$name}' already exists'");
                }

                $fields[$name] = true;
            }

            $this->data = $member->attachTo($this->data);
        }
    }
}
