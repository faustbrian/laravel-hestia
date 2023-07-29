<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\StoreTeam;

use BombenProdukt\Hestia\Models\Team;

final class StoreTeamResponse implements StoreTeamResponseInterface
{
    public function __construct(private readonly Team $team) {}

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request): Team
    {
        return $this->team;
    }
}
