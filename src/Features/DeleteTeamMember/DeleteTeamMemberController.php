<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeamMember;

use Illuminate\Http\Request;

final class DeleteTeamMemberController
{
    public function __invoke(Request $request, int $teamId, int $userId, DeleteTeamMemberInterface $deleteTeamMember): DeleteTeamMemberResponseInterface
    {
        return $deleteTeamMember($request->user(), $teamId, $userId);
    }
}
