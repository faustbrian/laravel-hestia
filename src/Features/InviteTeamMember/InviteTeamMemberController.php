<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\InviteTeamMember;

use Illuminate\Http\Request;

final class InviteTeamMemberController
{
    public function __invoke(Request $request, int $teamId, InviteTeamMemberInterface $inviteTeamMember): InviteTeamMemberResponseInterface
    {
        return $inviteTeamMember($request->user(), $teamId, $request->email, $request->role);
    }
}
