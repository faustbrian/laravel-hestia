<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\StoreTeam;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use BombenProdukt\Hestia\Events\AddingTeam;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

final class StoreTeam implements StoreTeamInterface
{
    public function __invoke(HasTeamsInterface $user, array $input): StoreTeamResponseInterface
    {
        Gate::forUser($user)->authorize('create', Eloquent::teamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        AddingTeam::dispatch($user);

        $user->switchTeam(
            $team = $user->ownedTeams()->create([
                'name' => $input['name'],
                'personal_team' => false,
            ]),
        );

        return App::make(StoreTeamResponseInterface::class, ['team' => $team]);
    }
}
