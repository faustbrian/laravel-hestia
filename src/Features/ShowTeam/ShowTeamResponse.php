<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\ShowTeam;

use BombenProdukt\Hestia\Authorization\Authorization;
use BombenProdukt\Hestia\Models\Team;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

final class ShowTeamResponse implements ShowTeamResponseInterface
{
    public function __construct(private readonly Team $team) {}

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request): Response
    {
        return Inertia::render('Teams/Show', [
            'team' => $this->team->load('owner', 'users', 'teamInvitations'),
            'availableRoles' => \array_values(Authorization::$roles),
            'availablePermissions' => Authorization::$permissions,
            'defaultPermissions' => Authorization::$defaultPermissions,
            'permissions' => [
                'canAddTeamMembers' => Gate::check('addTeamMember', $this->team),
                'canDeleteTeam' => Gate::check('delete', $this->team),
                'canRemoveTeamMembers' => Gate::check('removeTeamMember', $this->team),
                'canUpdateTeam' => Gate::check('update', $this->team),
                'canUpdateTeamMembers' => Gate::check('updateTeamMember', $this->team),
            ],
        ]);
    }
}
