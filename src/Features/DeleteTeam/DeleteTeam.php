<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeam;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

final class DeleteTeam implements DeleteTeamInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId): DeleteTeamResponseInterface
    {
        $team = Eloquent::findTeam($teamId);

        Gate::forUser($user)->authorize('delete', $team);

        if ($team->personal_team) {
            throw ValidationException::withMessages([
                'team' => __('You may not delete your personal team.'),
            ]);
        }

        $team->purge();

        return App::make(DeleteTeamResponseInterface::class);
    }
}
