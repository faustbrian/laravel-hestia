<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\UpdateTeamName;

use Illuminate\Http\Request;

final class UpdateTeamNameController
{
    public function __invoke(Request $request, int $teamId, UpdateTeamNameInterface $updateTeamName): UpdateTeamNameResponseInterface
    {
        return $updateTeamName($request->user(), $teamId, $request->all());
    }
}
