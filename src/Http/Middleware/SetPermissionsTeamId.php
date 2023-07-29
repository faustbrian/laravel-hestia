<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

final readonly class SetPermissionsTeamId
{
    public function __construct(private PermissionRegistrar $permissionRegistrar) {}

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user?->current_team_id !== null) {
            $this->permissionRegistrar->setPermissionsTeamId($user->current_team_id);
        }

        return $next($request);
    }
}
