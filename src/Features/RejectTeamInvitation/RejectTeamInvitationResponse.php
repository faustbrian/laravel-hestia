<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\RejectTeamInvitation;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

final class RejectTeamInvitationResponse implements RejectTeamInvitationResponseInterface
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request): RedirectResponse
    {
        return Redirect::back(303);
    }
}
