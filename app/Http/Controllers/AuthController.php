<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\SpotifyAccessToken;

use App\Helpers\Spotify;

class AuthController extends Controller
{
    public function login()
    {
        $client = env('SPOTIFY_CLIENT_ID');
        $redirect = url('/') . env('SPOTIFY_CALLBACK');

        // Add to session to compare below
        $state = 'test';
        $scope = 'user-read-email%20user-read-private%20user-read-playback-state%20user-modify-playback-state';

        $url = 'https://accounts.spotify.com/authorize?response_type=code&client_id=' . $client . '&scope=' . $scope . '&redirect_uri=' . $redirect . '&state=' . $state;

        return $url;
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
        } catch (\Throwable $e) {
            return response()->json([
                'success'      => false,
            ], 400);
        }
        
        return response()->json([
            'success'      => true,
        ], 200);
    }

    public function callback(Request $request)
    {

        // Compare states eventually with sessions
        $codeData = json_decode(Spotify::requestAccessToken($request->code), true);
        $expiryDate = date('Y-m-d H:i:s', time() + (int)$codeData['expires_in']);

        // Get user data, make entries
        $userData = json_decode(Spotify::getMe($codeData['access_token']));

        $user = User::firstOrCreate(
            [ 'name'    => $userData->display_name ],
            [ 'email'   => $userData->email ],
            [ 'avatar'  => $userData->images[0]->url ]
        );

        $spotifyEntry = SpotifyAccessToken::updateOrCreate(
            [ 'user_id'         => $user->id ],
            [ 'access_token'    => $codeData['access_token'], 'refresh_token' => $codeData['refresh_token'], 'scope' => $codeData['scope'], 'last_used_at' => date('Y-m-d H:i:s'), 'expires_at' => $expiryDate ],
        );
        $token = '';

        try {
            $token = $user->createToken('queue-token')->plainTextToken;
        } catch (\Throwable $e) {
            return response()->json([
                'success'   => false,
                'data'     => 'Unable to login'
            ], 400);
        }

        // Auth User
        return response()->json([
            'user'      => $user,
            'token'     => $token
        ], 200);
    }
}
