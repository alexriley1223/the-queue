<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\Spotify\SpotifyPublicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/user/me', function() {
        return auth()->user();
    });

    /*
        Route::get('/test', function() {
            $sp = new App\Helpers\SpotifyAuth;
        
            return $sp->getUserAccessToken();
        });
    */

    Route::get('/user/queue', [ QueueController::class, 'get' ]);
    Route::post('/user/queue/add', [ QueueController::class, 'add' ]);
    Route::post('/user/queue/remove', [ QueueController::class, 'remove' ]);
    
    Route::post('/auth/logout', [ AuthController::class, 'logout']);

    /* Private Spotify Routes 
        Route::prefix('/spotify/private')->group(function () {

        });
    */

});

/* Public Auth Routes */
Route::post('/auth/login', [ AuthController::class, 'login' ]);
Route::post('/auth/callback', [ AuthController::class, 'callback' ]);

/* Public Spotify Routes */
Route::prefix('/spotify/public')->group(function () {
    Route::post('/search', [ SpotifyPublicController::class, 'search' ]);
});

Route::post('/code/verify', function(Request $request) {
    // TODO: Validation
    try {
        $user = App\Models\User::where('code', $request->code)->firstOrFail();

        return response()->json([
            'code'      => $user->code,
        ], 200);
    } catch (Throwable $e) {
        return response()->json([
            'error'      => 'Valid code not found'
        ], 400);
    }
    
});


