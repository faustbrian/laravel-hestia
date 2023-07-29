<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Features\UpdateTeamName;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

final class UpdateTeamName implements UpdateTeamNameInterface
{
    public function __invoke(HasTeamsInterface $user, int $teamId, array $input): UpdateTeamNameResponseInterface
    {
        $team = Eloquent::findTeam($teamId);

        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        $team->forceFill([
            'name' => $input['name'],
        ])->save();

        return App::make(UpdateTeamNameResponse::class);
    }
}
