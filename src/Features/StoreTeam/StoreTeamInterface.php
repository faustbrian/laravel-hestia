<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\StoreTeam;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;

interface StoreTeamInterface
{
    public function __invoke(HasTeamsInterface $user, array $input): StoreTeamResponseInterface;
}
