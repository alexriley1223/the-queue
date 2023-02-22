<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class SpotifyAuth {
    private const SPOTIFY_AUTH_URL = 'https://accounts.spotify.com/api/token';
    
    private $spotifyClientId;
    private $spotifyClientSecret;

    public function __construct()
    {
        $this->spotifyClientId = env('SPOTIFY_CLIENT_ID');
        $this->spotifyClientSecret =  env('SPOTIFY_CLIENT_SECRET');
    }

    public function requestAccessToken($code)
    {
        $redirect = url('/') . env('SPOTIFY_CALLBACK');
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->spotifyClientId.":".$this->spotifyClientSecret),
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::SPOTIFY_AUTH_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $code . "&redirect_uri=" . $redirect);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        $data = json_decode($server_output);


        if(isset($data->error)) {
            report('Error fetching access token');
        } else {
            Cache::put('spotify-token', $data->access_token, $data->expires_in);
        }

        return $server_output;
    }

    private function generateServerAccessToken()
    {
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->spotifyClientId.":".$this->spotifyClientSecret),
        );

        // TODO: Keep this DRY
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::SPOTIFY_AUTH_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $data = json_decode($server_output);

        // TODO: Make custom error handler
        if(isset($data->error)) {
            report('Error fetching access token');
        } else {
            Cache::put('spotify-token', $data->access_token, $data->expires_in);
        }
    }

    private function regenerateUserAccessToken($refreshToken)
    {
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->spotifyClientId.":".$this->spotifyClientSecret),
        );

        // TODO: Keep this DRY
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::SPOTIFY_AUTH_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=" . $refreshToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $data = json_decode($server_output);

        // TODO: Make custom error handler
        if(isset($data->error)) {
            report('Error fetching access token');
        } else {
            $user = auth()->user();
            
            $user->spotifyToken->update([
                'access_token'  => $data->access_token,
                'expires_at' => date("Y-m-d H:i:s", strtotime('+'. $data->expires_in.' seconds'))
            ]);
        }
    }

    public function getAccessToken()
    {
        if(!Cache::has('spotify-token')) {
            $this->generateServerAccessToken();
        }

        return Cache::get('spotify-token');
    }

    public function getUserAccessToken()
    {
        $user = auth()->user();

        if(strtotime($user->spotifyToken->expires_at) < time() ) {
            $this->regenerateUserAccessToken($user->spotifyToken->refresh_token);
        }

        return auth()->user()->spotifyToken->access_token;
    }

    public function generateAuthorizeUrl()
    {
        $redirect = url('/') . env('SPOTIFY_CALLBACK');
        // TODO: Generate dynamic states for client/server verification
        $state = 'test';
        $scope = 'user-read-email%20user-read-private%20user-read-playback-state%20user-modify-playback-state';

        $url = 'https://accounts.spotify.com/authorize?response_type=code&client_id=' . $this->spotifyClientId . '&scope=' . $scope . '&redirect_uri=' . $redirect . '&state=' . $state;

        return $url;
    }

}