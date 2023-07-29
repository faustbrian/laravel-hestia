<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Models;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property bool   $personal_team
 */
abstract class Team extends Model
{
    /**
     * Get the owner of the team.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Eloquent::userModel(), 'user_id');
    }

    /**
     * Get all of the team's users including its owner.
     */
    public function allUsers(): Collection
    {
        return $this->users->merge([$this->owner]);
    }

    /**
     * Get all of the users that belong to the team.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Eloquent::userModel(), Eloquent::membershipModel())
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    /**
     * Determine if the given user belongs to the team.
     */
    public function hasUser(HasTeamsInterface $user): bool
    {
        return $this->users->contains($user) || $user->ownsTeam($this);
    }

    /**
     * Determine if the given email address belongs to a user on the team.
     */
    public function hasUserWithEmail(string $email): bool
    {
        return $this->allUsers()->contains(fn ($user) => $user->email === $email);
    }

    /**
     * Determine if the given user has the given permission on the team.
     */
    public function userHasPermission(HasTeamsInterface $user, string $permission): bool
    {
        return $user->hasTeamPermission($this, $permission);
    }

    /**
     * Get all of the pending user invitations for the team.
     */
    public function teamInvitations(): HasMany
    {
        return $this->hasMany(Eloquent::teamInvitationModel());
    }

    /**
     * Remove the given user from the team.
     */
    public function removeUser(HasTeamsInterface $user): void
    {
        if ($user->current_team_id === $this->id) {
            $user->forceFill([
                'current_team_id' => null,
            ])->save();
        }

        $this->users()->detach($user);
    }

    /**
     * Purge all of the team's resources.
     */
    public function purge(): void
    {
        $this->owner()->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->detach();

        $this->delete();
    }
}
