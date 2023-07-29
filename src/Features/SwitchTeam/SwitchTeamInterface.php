<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\SwitchTeam;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface SwitchTeamInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId): SwitchTeamResponseInterface;
}
