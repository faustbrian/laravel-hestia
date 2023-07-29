<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Concerns;

use BombenProdukt\Hestia\Authorization\Role;
use BombenProdukt\Hestia\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

interface HasTeamsInterface
{
    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(Team $team): bool;

    /**
     * Get the current team of the user's context.
     */
    public function currentTeam(): BelongsTo;

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(Team $team): bool;

    /**
     * Get all of the teams the user owns or belongs to.
     */
    public function allTeams(): Collection;

    /**
     * Get all of the teams the user owns.
     */
    public function ownedTeams(): HasMany;

    /**
     * Get all of the teams the user belongs to.
     */
    public function teams(): BelongsToMany;

    /**
     * Get the user's "personal" team.
     */
    public function personalTeam(): Team;

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(Team $team): bool;

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToTeam(Team $team): bool;

    /**
     * Get the role that the user has on the team.
     */
    public function teamRole(Team $team): ?Role;

    /**
     * Determine if the user has the given role on the given team.
     */
    public function hasTeamRole(Team $team, string $role): bool;

    /**
     * Get the user's permissions for the given team.
     */
    public function teamPermissions(Team $team): array;

    /**
     * Determine if the user has the given permission on the given team.
     */
    public function hasTeamPermission(Team $team, string $permission): bool;
}
