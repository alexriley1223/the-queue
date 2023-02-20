<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\SpotifyAccessToken;

use App\Helpers\SpotifyAuth;
use App\Helpers\Spotify;

class AuthController extends Controller
{
    public function login()
    {
        $spotifyAuth = new SpotifyAuth;
        return $spotifyAuth->generateAuthorizeUrl();
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
        $spotifyAuth = new SpotifyAuth;

        // Compare states eventually with sessions
        $codeData = json_decode($spotifyAuth->requestAccessToken($request->code), true);

        if(isset($codeData['error'])) {
            return response()->json([
                'success'   => false,
                'data'     => $codeData['error_description']
            ], 400);
        }
        $expiryDate = date('Y-m-d H:i:s', time() + (int)$codeData['expires_in']);

        // Get user data, make entries
        $userData = json_decode(Spotify::getMe($codeData['access_token']));
        
        $user = User::firstOrCreate(
            [ 'email' => $userData->email ],
            [ 
                'name' => $userData->display_name,
                'avatar' => $userData->images[0]->url,
                'code' => Str::lower(Str::random(8))  
            ],
        );
        
        SpotifyAccessToken::updateOrCreate(
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
