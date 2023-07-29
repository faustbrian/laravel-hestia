<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\InviteTeamMember;

use BombenProdukt\Hestia\Authorization\Authorization;
use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use BombenProdukt\Hestia\Events\InvitingTeamMember;
use BombenProdukt\Hestia\Mail\TeamInvitation;
use BombenProdukt\Hestia\Models\Team;
use BombenProdukt\Hestia\Rules\Role;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class InviteTeamMember implements InviteTeamMemberInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, string $email, ?string $role = null): InviteTeamMemberResponseInterface
    {
        $team = Eloquent::findTeam($teamId);

        Gate::forUser($user)->authorize('addTeamMember', $team);

        $this->validate($team, $email, $role);

        InvitingTeamMember::dispatch($team, $email, $role);

        $invitation = $team->teamInvitations()->create([
            'email' => $email,
            'role' => $role,
        ]);

        Mail::to($email)->send(new TeamInvitation($invitation));

        return App::make(InviteTeamMemberResponseInterface::class);
    }

    private function validate(Team $team, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules($team), [
            'email.unique' => __('This user has already been invited to the team.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email),
        )->validate();
    }

    private function rules(Team $team): array
    {
        return \array_filter([
            'email' => [
                'required', 'email',
                Rule::unique('team_invitations')->where(function (Builder $query) use ($team): void {
                    $query->where('team_id', $team->id);
                }),
            ],
            'role' => Authorization::hasRoles() ? ['required', 'string', new Role()] : null,
        ]);
    }

    private function ensureUserIsNotAlreadyOnTeam(Team $team, string $email): Closure
    {
        return function ($validator) use ($team, $email): void {
            $validator->errors()->addIf(
                $team->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the team.'),
            );
        };
    }
}
