<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\RejectTeamInvitation;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

final class RejectTeamInvitation implements RejectTeamInvitationInterface
{
    public function __invoke(HasTeamsInterface $user, int $invitationId): RejectTeamInvitationResponseInterface
    {
        $invitation = Eloquent::findTeamInvitation($invitationId);

        if (!Gate::forUser($user)->check('removeTeamMember', $invitation->team)) {
            throw new AuthorizationException();
        }

        $invitation->delete();

        return App::make(RejectTeamInvitationResponseInterface::class);
    }
}
