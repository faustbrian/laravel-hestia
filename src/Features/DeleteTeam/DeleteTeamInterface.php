<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\DeleteTeam;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface DeleteTeamInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId): DeleteTeamResponseInterface;
}
