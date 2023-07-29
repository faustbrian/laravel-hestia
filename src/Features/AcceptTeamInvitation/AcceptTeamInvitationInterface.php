<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\AcceptTeamInvitation;

interface AcceptTeamInvitationInterface
{
    public function __invoke(int $invitationId): AcceptTeamInvitationResponseInterface;
}
