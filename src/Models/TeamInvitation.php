<?php

declare(strict_types=1);

namespace BombenProdukt\Hestia\Models;

use BombenProdukt\Hestia\Configuration\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TeamInvitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Eloquent::teamModel());
    }
}
