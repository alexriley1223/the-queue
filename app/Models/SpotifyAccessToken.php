<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpotifyAccessToken extends Model
{
    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'scope',
        'last_used_at',
        'expires_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
