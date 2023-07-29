<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\SwitchTeam;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

final class SwitchTeamResponse implements SwitchTeamResponseInterface
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request): RedirectResponse
    {
        return Redirect::to('/', 303);
    }
}
