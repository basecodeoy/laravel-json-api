<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

interface HasMembersInterface
{
    /**
     * @return list<MemberInterface>
     */
    public function getMembers(): array;

    public function addMember(MemberInterface $member): static;

    /**
     * @param list<MemberInterface> $members
     */
    public function addMembers(array $members): static;

    public function attachMembers(array $data): array;
}
