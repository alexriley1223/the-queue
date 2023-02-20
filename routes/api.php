<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
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
    
    /* Private Auth Routes */
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });
    Route::post('/auth/logout', [ AuthController::class, 'logout']);

    /* Private Spotify Routes */
    Route::prefix('/spotify/private')->group(function () {

    });

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


