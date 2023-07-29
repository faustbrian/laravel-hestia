<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeamMember;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

final class DeleteTeamMemberResponse implements DeleteTeamMemberResponseInterface
{
    public function __construct(private readonly HasTeamsInterface $user) {}

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toResponse($request): RedirectResponse
    {
        if (Request::user()->id === $this->user->id) {
            return Redirect::to(Config::get('fortify.home'));
        }

        return Redirect::back(303);
    }
}
