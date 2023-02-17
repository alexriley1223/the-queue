<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\Helpers\SpotifyAuth;

class GenerateSpotifyClientCredentials extends Command
{
    protected $signature = 'thequeue:generate';

    protected $description = 'Generate server-to-server client credentials for Spotify';

    public function handle(SpotifyAuth $spotifyAuth): void
    {
        $this->info('Generating Spotify client credentials');

        Cache::forget('spotify-token');
        $token = $spotifyAuth->getAccessToken();

        $this->info('New token: ' . $token);
    }
}
