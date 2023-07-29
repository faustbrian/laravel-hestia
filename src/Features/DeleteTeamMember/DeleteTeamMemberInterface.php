<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeamMember;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface DeleteTeamMemberInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, int $teamMemberId): DeleteTeamMemberResponseInterface;
}
