<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Rules;

use BombenProdukt\Hestia\Authorization\Authorization;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class Role implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!\in_array($value, \array_keys(Authorization::$roles), true)) {
            $fail(__('The :attribute must be a valid role.'));
        }
    }
}
