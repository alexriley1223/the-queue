<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
