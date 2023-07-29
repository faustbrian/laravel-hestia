<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\InviteTeamMember;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface InviteTeamMemberInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, string $email, ?string $role = null): InviteTeamMemberResponseInterface;
}
