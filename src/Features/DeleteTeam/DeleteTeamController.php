<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeam;

use Illuminate\Http\Request;

final class DeleteTeamController
{
    public function __invoke(Request $request, int $teamId, DeleteTeamInterface $deleteTeam): DeleteTeamResponseInterface
    {
        return $deleteTeam($request->user(), $teamId);
    }
}
