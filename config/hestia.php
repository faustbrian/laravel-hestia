<?php

declare(strict_types=1);

use BombenProdukt\Hestia\Features\AcceptTeamInvitation\AcceptTeamInvitationController;
use BombenProdukt\Hestia\Features\CreateTeam\CreateTeamController;
use BombenProdukt\Hestia\Features\DeleteTeam\DeleteTeamController;
use BombenProdukt\Hestia\Features\DeleteTeamMember\DeleteTeamMemberController;
use BombenProdukt\Hestia\Features\InviteTeamMember\InviteTeamMemberController;
use BombenProdukt\Hestia\Features\RejectTeamInvitation\RejectTeamInvitationController;
use BombenProdukt\Hestia\Features\ShowTeam\ShowTeamController;
use BombenProdukt\Hestia\Features\StoreTeam\StoreTeamController;
use BombenProdukt\Hestia\Features\SwitchTeam\SwitchTeamController;
use BombenProdukt\Hestia\Features\UpdateTeamMemberRole\UpdateTeamMemberRoleController;
use BombenProdukt\Hestia\Features\UpdateTeamName\UpdateTeamNameController;
use BombenProdukt\Hestia\Models\Membership;
use BombenProdukt\Hestia\Models\Team;
use BombenProdukt\Hestia\Models\TeamInvitation;

return [
    'models' => [
        'user' => 'App\\Models\\User',
        'team' => Team::class,
        'membership' => Membership::class,
        'team_invitation' => TeamInvitation::class,
    ],
    'routes' => [
        [
            'method' => 'get',
            'name' => 'teams.create',
            'path' => '/teams/create',
            'action' => CreateTeamController::class,
        ],
        [
            'method' => 'post',
            'name' => 'teams.store',
            'path' => '/teams',
            'action' => StoreTeamController::class,
        ],
        [
            'method' => 'get',
            'name' => 'teams.show',
            'path' => '/teams/{team}',
            'action' => ShowTeamController::class,
        ],
        [
            'method' => 'put',
            'name' => 'teams.update',
            'path' => '/teams/{team}',
            'action' => UpdateTeamNameController::class,
        ],
        [
            'method' => 'delete',
            'name' => 'teams.destroy',
            'path' => '/teams/{team}',
            'action' => DeleteTeamController::class,
        ],
        [
            'method' => 'put',
            'name' => 'current-team.update',
            'path' => '/current-team',
            'action' => SwitchTeamController::class,
        ],
        [
            'method' => 'post',
            'name' => 'team-members.store',
            'path' => '/teams/{team}/members',
            'action' => InviteTeamMemberController::class,
        ],
        [
            'method' => 'put',
            'name' => 'team-members.update',
            'path' => '/teams/{team}/members/{user}',
            'action' => UpdateTeamMemberRoleController::class,
        ],
        [
            'method' => 'delete',
            'name' => 'team-members.destroy',
            'path' => '/teams/{team}/members/{user}',
            'action' => DeleteTeamMemberController::class,
        ],
        [
            'method' => 'get',
            'name' => 'team-invitations.accept',
            'path' => '/team-invitations/{invitation}',
            'action' => AcceptTeamInvitationController::class,
            'middleware' => ['signed'],
        ],
        [
            'method' => 'delete',
            'name' => 'team-invitations.destroy',
            'path' => '/team-invitations/{invitation}',
            'action' => RejectTeamInvitationController::class,
        ],
    ],
];
