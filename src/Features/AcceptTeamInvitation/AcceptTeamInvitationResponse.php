<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\AcceptTeamInvitation;

use BombenProdukt\Hestia\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

final class AcceptTeamInvitationResponse implements AcceptTeamInvitationResponseInterface
{
    public function __construct(private readonly Team $team) {}

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request): RedirectResponse
    {
        return Redirect::to('/')->banner(
            __('Great! You have accepted the invitation to join the :team team.', ['team' => $this->team->name]),
        );
    }
}
