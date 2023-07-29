<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\ShowTeam;

use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

final class ShowTeam implements ShowTeamInterface
{
    public function __invoke(int $teamId): ShowTeamResponseInterface
    {
        $team = Eloquent::findTeam($teamId);

        Gate::authorize('view', $team);

        return App::make(ShowTeamResponseInterface::class, ['team' => $team]);
    }
}
