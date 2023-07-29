<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\SwitchTeam;

use Illuminate\Http\Request;

final class SwitchTeamController
{
    public function __invoke(Request $request, SwitchTeamInterface $switchTeam): SwitchTeamResponseInterface
    {
        return $switchTeam($request->user(), $request->team_id);
    }
}
