<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueuedTrack extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'queued_tracks';

    protected $fillable = [
        'user_id',
        'name',
        'uri',
        'artist',
        'image',
        'image_thumb',
        'added_at'
    ];
}
