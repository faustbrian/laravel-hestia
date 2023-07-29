<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia;

use BombenProdukt\Hestia\Features\AcceptTeamInvitation\AcceptTeamInvitation;
use BombenProdukt\Hestia\Features\AcceptTeamInvitation\AcceptTeamInvitationInterface;
use BombenProdukt\Hestia\Features\AcceptTeamInvitation\AcceptTeamInvitationResponse;
use BombenProdukt\Hestia\Features\AcceptTeamInvitation\AcceptTeamInvitationResponseInterface;
use BombenProdukt\Hestia\Features\CreateTeam\CreateTeam;
use BombenProdukt\Hestia\Features\CreateTeam\CreateTeamInterface;
use BombenProdukt\Hestia\Features\CreateTeam\CreateTeamResponse;
use BombenProdukt\Hestia\Features\CreateTeam\CreateTeamResponseInterface;
use BombenProdukt\Hestia\Features\DeleteTeam\DeleteTeam;
use BombenProdukt\Hestia\Features\DeleteTeam\DeleteTeamInterface;
use BombenProdukt\Hestia\Features\DeleteTeam\DeleteTeamResponse;
use BombenProdukt\Hestia\Features\DeleteTeam\DeleteTeamResponseInterface;
use BombenProdukt\Hestia\Features\DeleteTeamMember\DeleteTeamMember;
use BombenProdukt\Hestia\Features\DeleteTeamMember\DeleteTeamMemberInterface;
use BombenProdukt\Hestia\Features\DeleteTeamMember\DeleteTeamMemberResponse;
use BombenProdukt\Hestia\Features\DeleteTeamMember\DeleteTeamMemberResponseInterface;
use BombenProdukt\Hestia\Features\InviteTeamMember\InviteTeamMember;
use BombenProdukt\Hestia\Features\InviteTeamMember\InviteTeamMemberInterface;
use BombenProdukt\Hestia\Features\InviteTeamMember\InviteTeamMemberResponse;
use BombenProdukt\Hestia\Features\InviteTeamMember\InviteTeamMemberResponseInterface;
use BombenProdukt\Hestia\Features\RejectTeamInvitation\RejectTeamInvitation;
use BombenProdukt\Hestia\Features\RejectTeamInvitation\RejectTeamInvitationInterface;
use BombenProdukt\Hestia\Features\RejectTeamInvitation\RejectTeamInvitationResponse;
use BombenProdukt\Hestia\Features\RejectTeamInvitation\RejectTeamInvitationResponseInterface;
use BombenProdukt\Hestia\Features\ShowTeam\ShowTeam;
use BombenProdukt\Hestia\Features\ShowTeam\ShowTeamInterface;
use BombenProdukt\Hestia\Features\ShowTeam\ShowTeamResponse;
use BombenProdukt\Hestia\Features\ShowTeam\ShowTeamResponseInterface;
use BombenProdukt\Hestia\Features\StoreTeam\StoreTeam;
use BombenProdukt\Hestia\Features\StoreTeam\StoreTeamInterface;
use BombenProdukt\Hestia\Features\StoreTeam\StoreTeamResponse;
use BombenProdukt\Hestia\Features\StoreTeam\StoreTeamResponseInterface;
use BombenProdukt\Hestia\Features\SwitchTeam\SwitchTeam;
use BombenProdukt\Hestia\Features\SwitchTeam\SwitchTeamInterface;
use BombenProdukt\Hestia\Features\SwitchTeam\SwitchTeamResponse;
use BombenProdukt\Hestia\Features\SwitchTeam\SwitchTeamResponseInterface;
use BombenProdukt\Hestia\Features\UpdateTeamMemberRole\UpdateTeamMemberRole;
use BombenProdukt\Hestia\Features\UpdateTeamMemberRole\UpdateTeamMemberRoleInterface;
use BombenProdukt\Hestia\Features\UpdateTeamMemberRole\UpdateTeamMemberRoleResponse;
use BombenProdukt\Hestia\Features\UpdateTeamMemberRole\UpdateTeamMemberRoleResponseInterface;
use BombenProdukt\Hestia\Features\UpdateTeamName\UpdateTeamName;
use BombenProdukt\Hestia\Features\UpdateTeamName\UpdateTeamNameInterface;
use BombenProdukt\Hestia\Features\UpdateTeamName\UpdateTeamNameResponse;
use BombenProdukt\Hestia\Features\UpdateTeamName\UpdateTeamNameResponseInterface;
use BombenProdukt\Hestia\Http\Middleware\SetPermissionsTeamId;
use BombenProdukt\PackagePowerPack\Package\AbstractServiceProvider;
use Illuminate\Contracts\Http\Kernel as KernelContract;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

final class ServiceProvider extends AbstractServiceProvider
{
    public function packageRegistered(): void
    {
        $this->registerFeatures();

        $this->registerRoutes();

        $this->registerMiddleware();
    }

    private function registerFeatures(): void
    {
        $this->app->bind(AcceptTeamInvitationInterface::class, AcceptTeamInvitation::class);
        $this->app->bind(AcceptTeamInvitationResponseInterface::class, AcceptTeamInvitationResponse::class);

        $this->app->bind(CreateTeamInterface::class, CreateTeam::class);
        $this->app->bind(CreateTeamResponseInterface::class, CreateTeamResponse::class);

        $this->app->bind(DeleteTeamInterface::class, DeleteTeam::class);
        $this->app->bind(DeleteTeamResponseInterface::class, DeleteTeamResponse::class);

        $this->app->bind(DeleteTeamMemberInterface::class, DeleteTeamMember::class);
        $this->app->bind(DeleteTeamMemberResponseInterface::class, DeleteTeamMemberResponse::class);

        $this->app->bind(InviteTeamMemberInterface::class, InviteTeamMember::class);
        $this->app->bind(InviteTeamMemberResponseInterface::class, InviteTeamMemberResponse::class);

        $this->app->bind(RejectTeamInvitationInterface::class, RejectTeamInvitation::class);
        $this->app->bind(RejectTeamInvitationResponseInterface::class, RejectTeamInvitationResponse::class);

        $this->app->bind(ShowTeamInterface::class, ShowTeam::class);
        $this->app->bind(ShowTeamResponseInterface::class, ShowTeamResponse::class);

        $this->app->bind(StoreTeamInterface::class, StoreTeam::class);
        $this->app->bind(StoreTeamResponseInterface::class, StoreTeamResponse::class);

        $this->app->bind(SwitchTeamInterface::class, SwitchTeam::class);
        $this->app->bind(SwitchTeamResponseInterface::class, SwitchTeamResponse::class);

        $this->app->bind(UpdateTeamMemberRoleInterface::class, UpdateTeamMemberRole::class);
        $this->app->bind(UpdateTeamMemberRoleResponseInterface::class, UpdateTeamMemberRoleResponse::class);

        $this->app->bind(UpdateTeamNameInterface::class, UpdateTeamName::class);
        $this->app->bind(UpdateTeamNameResponseInterface::class, UpdateTeamNameResponse::class);
    }

    private function registerRoutes(): void
    {
        foreach (Config::get('hestia.routes') as $route) {
            $pendingRoute = Route::match($route['method'], $route['path'], $route['action']);

            if (isset($route['middleware'])) {
                $pendingRoute->middleware($route['middleware']);
            }

            $pendingRoute->name($route['name']);
        }
    }

    private function registerMiddleware(): void
    {
        /** @var Kernel $kernel */
        $kernel = $this->app->make(KernelContract::class);
        $kernel->appendMiddlewareToGroup('web', SetPermissionsTeamId::class);
        $kernel->appendToMiddlewarePriority(SetPermissionsTeamId::class);
    }
}
