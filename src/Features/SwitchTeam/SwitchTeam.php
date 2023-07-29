<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\SwitchTeam;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Support\Facades\App;

final class SwitchTeam implements SwitchTeamInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId): SwitchTeamResponseInterface
    {
        $team = Eloquent::findTeam($teamId);

        abort_unless(403, $user->switchTeam($team));

        return App::make(SwitchTeamResponseInterface::class);
    }
}
