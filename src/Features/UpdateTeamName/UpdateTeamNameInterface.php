<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\UpdateTeamName;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface UpdateTeamNameInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, array $input): UpdateTeamNameResponseInterface;
}
