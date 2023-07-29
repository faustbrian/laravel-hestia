<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\UpdateTeamMemberRole;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface UpdateTeamMemberRoleInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, int $teamMemberId, string $role): UpdateTeamMemberRoleResponseInterface;
}
