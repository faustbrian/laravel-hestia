<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Authorization;

use JsonSerializable;

final class Role implements JsonSerializable
{
    public function __construct(
        private readonly string $key,
        private readonly string $name,
        private readonly string $description,
        private readonly array $permissions,
    ) {
        //
    }

    public static function owner(): self
    {
        return new self(
            'owner',
            'Owner',
            'Owners can perform any action.',
            ['*'],
        );
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'name' => __($this->name),
            'description' => __($this->description),
            'permissions' => $this->permissions,
        ];
    }
}
