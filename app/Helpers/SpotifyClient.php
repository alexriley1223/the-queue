<?php

namespace App\Helpers;


class SpotifyClient {
    private const SPOTIFY_API_URL = 'https://api.spotify.com/v1/me';

    private $accessToken;
    private $params;

    public function __construct($params)
    {
        $this->accessToken = (new SpotifyAuth)->getUserAccessToken();
        $this->params = $params;
    }

    public function addToQueue()
    {
        $endpoint = '/player/queue';
        $this->postRequest($endpoint);
    }

    private function postRequest($endpoint)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Length: 0'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::SPOTIFY_API_URL . $endpoint . '?' . http_build_query($this->params));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        $server_output = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close ($ch);
        
        $data = json_decode($server_output);
        
        \Log::info($status);

        // TODO: Make custom error handler
        if($status != 204) {
            report('Error');
        }
    }
}