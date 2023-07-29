<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\CreateTeam;

use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

final class CreateTeam implements CreateTeamInterface
{
    public function __invoke(): CreateTeamResponseInterface
    {
        Gate::authorize('create', Eloquent::teamModel());

        return App::resolve(CreateTeamResponseInterface::class);
    }
}
