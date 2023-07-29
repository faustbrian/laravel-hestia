<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\AcceptTeamInvitation;

final class AcceptTeamInvitationController
{
    public function __invoke(int $invitationId, AcceptTeamInvitationInterface $acceptTeamInvitation): AcceptTeamInvitationResponseInterface
    {
        return $acceptTeamInvitation($invitationId);
    }
}
