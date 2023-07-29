<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\RejectTeamInvitation;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface RejectTeamInvitationInterface
{
    public function __invoke(HasTeamsInterface $user, int $invitationId): RejectTeamInvitationResponseInterface;
}
