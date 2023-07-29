<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Concerns;

use BombenProdukt\Hestia\Authorization\Authorization;
use BombenProdukt\Hestia\Authorization\Role;
use BombenProdukt\Hestia\Configuration\Eloquent;
use BombenProdukt\Hestia\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @see HasTeamsInterface
 */
trait HasTeams
{
    public function isCurrentTeam(Team $team): bool
    {
        return $team->id === $this->currentTeam->id;
    }

    public function currentTeam(): BelongsTo
    {
        if (null === $this->current_team_id && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        return $this->belongsTo(Eloquent::teamModel(), 'current_team_id');
    }

    public function switchTeam(Team $team): bool
    {
        if (!$this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('currentTeam', $team);

        return true;
    }

    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Eloquent::teamModel());
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Eloquent::teamModel(), Eloquent::membershipModel())
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    public function personalTeam(): ?Team
    {
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    public function ownsTeam($team)
    {
        if (null === $team) {
            return false;
        }

        return $this->id === $team->{$this->getForeignKey()};
    }

    public function belongsToTeam(Team $team): bool
    {
        if (null === $team) {
            return false;
        }

        return $this->ownsTeam($team) || $this->teams->contains(function ($t) use ($team) {
            return $t->id === $team->id;
        });
    }

    public function teamRole(Team $team): ?Role
    {
        if ($this->ownsTeam($team)) {
            return Role::owner();
        }

        if (!$this->belongsToTeam($team)) {
            return null;
        }

        $role = $team->users
            ->where('id', $this->id)
            ->first()
            ->membership
            ->role;

        return $role ? Authorization::findRole($role) : null;
    }

    public function hasTeamRole(Team $team, string $role): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        return $this->belongsToTeam($team) && optional(Authorization::findRole($team->users->where(
            'id',
            $this->id,
        )->first()->membership->role))->key === $role;
    }

    public function teamPermissions(Team $team): array
    {
        if ($this->ownsTeam($team)) {
            return ['*'];
        }

        if (!$this->belongsToTeam($team)) {
            return [];
        }

        return (array) optional($this->teamRole($team))->permissions;
    }

    public function hasTeamPermission(Team $team, string $permission): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        if (!$this->belongsToTeam($team)) {
            return false;
        }

        if (\in_array(HasApiTokens::class, class_uses_recursive($this), true)
            && !$this->tokenCan($permission)
            && $this->currentAccessToken() !== null) {
            return false;
        }

        $permissions = $this->teamPermissions($team);

        return \in_array($permission, $permissions, true)
               || \in_array('*', $permissions, true)
               || (Str::endsWith($permission, ':create') && \in_array('*:create', $permissions, true))
               || (Str::endsWith($permission, ':update') && \in_array('*:update', $permissions, true));
    }
}
