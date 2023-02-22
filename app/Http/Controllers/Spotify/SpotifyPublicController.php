<?php

namespace App\Http\Controllers\Spotify;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpotifyPublicController extends Controller
{
    public function search(Request $request)
    {
        // TODO: Validation
        $params = array(
            'q'     => $request->q,
            'type'  => 'track',
            'limit' => 6
        );

        $search = new \App\Helpers\SpotifyServer($params);

        return $search->search();
    }
}
