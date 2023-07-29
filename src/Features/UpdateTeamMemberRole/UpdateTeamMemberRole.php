<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\UpdateTeamMemberRole;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use BombenProdukt\Hestia\Events\TeamMemberUpdated;
use BombenProdukt\Hestia\Rules\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

final class UpdateTeamMemberRole implements UpdateTeamMemberRoleInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, int $teamMemberId, string $role): UpdateTeamMemberRoleResponseInterface
    {
        $team = Eloquent::findTeam($teamId);

        Gate::forUser($user)->authorize('updateTeamMember', $team);

        Validator::make([
            'role' => $role,
        ], [
            'role' => ['required', 'string', new Role()],
        ])->validate();

        $team->users()->updateExistingPivot($teamMemberId, [
            'role' => $role,
        ]);

        TeamMemberUpdated::dispatch($team->fresh(), Eloquent::findUser($teamMemberId));

        return App::make(UpdateTeamMemberRoleResponseInterface::class);
    }
}
