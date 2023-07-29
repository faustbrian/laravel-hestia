<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Events;

use BombenProdukt\Hestia\Models\Team;
use Illuminate\Foundation\Events\Dispatchable;

final class InvitingTeamMember
{
    use Dispatchable;

    public function __construct(
        public readonly Team $team,
        public readonly string $email,
        public readonly string $role,
    ) {}
}
