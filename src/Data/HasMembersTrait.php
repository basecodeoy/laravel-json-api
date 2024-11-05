<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

trait HasMembersTrait
{
    /**
     * @var list<MemberInterface>
     */
    protected array $members = [];

    /**
     * @return list<MemberInterface>
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    public function addMember(MemberInterface $member): static
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * @param list<MemberInterface> $members
     */
    public function addMembers(array $members): static
    {
        foreach ($members as $member) {
            $this->addMember($member);
        }

        return $this;
    }

    public function attachMembers(array $data = []): array
    {
        if (\count($this->members) > 0) {
            foreach ($this->members as $member) {
                $data = $member->attachTo($data);
            }
        }

        return $data;
    }
}
