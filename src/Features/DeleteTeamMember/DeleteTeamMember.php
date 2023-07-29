<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeamMember;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use BombenProdukt\Hestia\Events\TeamMemberRemoved;
use BombenProdukt\Hestia\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

final class DeleteTeamMember implements DeleteTeamMemberInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, int $teamMemberId): DeleteTeamMemberResponseInterface
    {
        $team = Eloquent::findTeam($teamId);
        $teamMember = Eloquent::findUser($teamMemberId);

        $this->authorize($user, $team, $teamMember);

        $this->ensureUserDoesNotOwnTeam($teamMember, $team);

        $team->removeUser($teamMember);

        TeamMemberRemoved::dispatch($team, $teamMember);

        return App::make(DeleteTeamMemberResponse::class, ['user' => $teamMember]);
    }

    private function authorize(HasTeamsInterface $user, Team $team, HasTeamsInterface $teamMember): void
    {
        $authorized = Gate::forUser($user)->check('removeTeamMember', $team);

        if ($authorized) {
            return;
        }

        if ($user->id !== $teamMember->id) {
            throw new AuthorizationException();
        }
    }

    private function ensureUserDoesNotOwnTeam(HasTeamsInterface $teamMember, Team $team): void
    {
        if ($teamMember->id === $team->owner->id) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ]);
        }
    }
}
