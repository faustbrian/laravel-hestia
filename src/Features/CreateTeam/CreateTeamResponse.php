<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\CreateTeam;

use Inertia\Inertia;

final class CreateTeamResponse implements CreateTeamResponseInterface
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request)
    {
        return Inertia::render('Teams/Create');
    }
}
