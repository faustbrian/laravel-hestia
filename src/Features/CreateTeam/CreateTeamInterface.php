<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\CreateTeam;

interface CreateTeamInterface
{
    public function __invoke(): CreateTeamResponseInterface;
}
