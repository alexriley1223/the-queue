<?php

namespace App\Helpers;

class Spotify {

    public function __construct() {}

    public static function requestAccessToken($code)
    {
        $redirect = url('/') . env('SPOTIFY_CALLBACK');
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode(env('SPOTIFY_CLIENT_ID').":".env('SPOTIFY_CLIENT_SECRET')),
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $code . "&redirect_uri=" . $redirect);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        return $server_output;
    }

    public static function getMe($code)
    {
        $header = array(
            'Authorization: Bearer ' . $code,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close($ch);

        return $server_output;
    }
}