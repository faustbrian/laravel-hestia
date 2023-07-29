<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\AcceptTeamInvitation;

use BombenProdukt\Hestia\Authorization\Authorization;
use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use BombenProdukt\Hestia\Events\AddingTeamMember;
use BombenProdukt\Hestia\Events\TeamMemberAdded;
use BombenProdukt\Hestia\Models\Team;
use BombenProdukt\Hestia\Rules\Role;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

final class AcceptTeamInvitation implements AcceptTeamInvitationInterface
{
    public function __invoke(int $invitationId): AcceptTeamInvitationResponseInterface
    {
        $invitation = Eloquent::findTeamInvitation($invitationId);

        $this->addTeamMember(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role,
        );

        $invitation->delete();

        return App::make(AcceptTeamInvitationResponse::class, ['team' => $invitation->team]);
    }

    private function addTeamMember(HasTeamsInterface $user, Team $team, string $email, ?string $role = null): void
    {
        Gate::forUser($user)->authorize('addTeamMember', $team);

        $this->validate($team, $email, $role);

        $newTeamMember = Eloquent::findUserByEmail($email);

        AddingTeamMember::dispatch($team, $newTeamMember);

        $team->users()->attach(
            $newTeamMember,
            ['role' => $role],
        );

        TeamMemberAdded::dispatch($team, $newTeamMember);
    }

    private function validate(Team $team, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules(), [
            'email.exists' => __('We were unable to find a registered user with this email address.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email),
        )->validate();
    }

    private function rules(): array
    {
        return \array_filter([
            'email' => ['required', 'email', 'exists:users'],
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
