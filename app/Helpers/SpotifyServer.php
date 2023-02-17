<?php

namespace App\Helpers;

class SpotifyServer {
    private const SPOTIFY_API_URL = 'https://api.spotify.com/v1';

    private $accessToken;
    private $params;

    public function __construct($params)
    {
        $this->accessToken = (new SpotifyAuth)->getAccessToken();
        $this->params = $params;
    }

    /**
     * Get Spotify catalog information about albums, artists, playlists, tracks, shows, episodes or audiobooks that match a keyword string.
     */
    public function search()
    {
        $endpoint = '/search';

        $searchRequest = $this->getRequest($endpoint);

        $filteredTracks = array();

        foreach($searchRequest->tracks->items as $track) {
            $artists = array();

            foreach($track->artists as $artist) {
                array_push($artists, $artist->name);
            }

            array_push($filteredTracks, array(
                'id'            => $track->id,
                'uri'           => $track->uri,
                'track'         => $track->name,
                'album'         => $track->album->name,
                'artist'        => implode(', ', $artists),
                // 'runtime'       => gmdate("g:i:s", $track->duration_ms),
                'image'         => $track->album->images[0]->url,
                'image_thumb'   => $track->album->images[2]->url
            ));
        }

        return $filteredTracks;
    }

    /**
     * Get Spotify catalog information for a single track identified by its unique Spotify ID.
     */
    public function getTrack()
    {

    }

    private function getRequest($endpoint)
    {
        $header = array(
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::SPOTIFY_API_URL . $endpoint . '?' . http_build_query($this->params, '', '&amp;'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close($ch);

        return json_decode($server_output);
    }
}