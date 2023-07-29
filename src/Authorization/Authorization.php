<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Authorization;

final class Authorization
{
    /**
     * The roles that are available to assign to users.
     *
     * @var array
     */
    public static $roles = [];

    /**
     * The permissions that exist within the application.
     *
     * @var array
     */
    public static $permissions = [];

    /**
     * The default permissions that should be available to new entities.
     *
     * @var array
     */
    public static $defaultPermissions = [];

    /**
     * Determine if Jetstream has registered roles.
     *
     * @return bool
     */
    public static function hasRoles()
    {
        return \count(self::$roles) > 0;
    }

    /**
     * Find the role with the given key.
     */
    public static function findRole(string $key): ?Role
    {
        return self::$roles[$key] ?? null;
    }

    /**
     * Define a role.
     */
    public static function role(string $key, string $name, string $description, array $permissions): Role
    {
        self::$permissions = collect(\array_merge(self::$permissions, $permissions))
            ->unique()
            ->sort()
            ->values()
            ->all();

        return tap(new Role($key, $name, $description, $permissions), function ($role) use ($key): void {
            static::$roles[$key] = $role;
        });
    }

    /**
     * Determine if any permissions have been registered with Jetstream.
     *
     * @return bool
     */
    public static function hasPermissions()
    {
        return \count(self::$permissions) > 0;
    }

    /**
     * Define the available API token permissions.
     *
     * @return static
     */
    public static function permissions(array $permissions)
    {
        self::$permissions = $permissions;

        return new self();
    }

    /**
     * Define the default permissions that should be available to new API tokens.
     *
     * @return static
     */
    public static function defaultApiTokenPermissions(array $permissions)
    {
        self::$defaultPermissions = $permissions;

        return new self();
    }

    /**
     * Return the permissions in the given list that are actually defined permissions for the application.
     *
     * @return array
     */
    public static function validPermissions(array $permissions)
    {
        return \array_values(\array_intersect($permissions, self::$permissions));
    }
}
