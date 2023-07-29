<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Events;

use BombenProdukt\Hestia\Concerns\HasTeamsInterface;
use Illuminate\Foundation\Events\Dispatchable;

final class AddingTeam
{
    use Dispatchable;

    public function __construct(public readonly HasTeamsInterface $owner) {}
}
