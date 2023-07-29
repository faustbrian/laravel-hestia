<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\CreateTeam;

final class CreateTeamController
{
    public function __invoke(CreateTeamInterface $createTeam): CreateTeamResponseInterface
    {
        return $createTeam();
    }
}
