<?php

use App\Helpers\SpotifyAuth;
use App\Models\QueuedTrack;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/add', function(Request $request) {
    // TODO: Validation

    $code = $request->code;
    $name = $request->track['name'];
    $uri = $request->track['uri'];
    $artist = $request->track['artist'];

    $image = $request->track['image'];
    $imageThmb = $request->track['image_thumb'];


    $arr = [$code, $name, $uri, $artist, $image, $imageThmb];

    try {
        $user = App\Models\User::where('code', $request->code)->firstOrFail();
    } catch (Throwable $e) {
        return response()->json([
            'error'      => 'Valid code not supplied'
        ], 400);
    }

    $queuedTrack = App\Models\QueuedTrack::create([
        'user_id'   => $user->id,
        'name'      => $name,
        'uri'       => $uri,
        'artist'    => $artist,
        'image'     => $image,
        'image_thumb' => $imageThmb
    ]);
    
    return response()->json([
        'success'      => 'Song added to queue with code ' . $user->code
    ], 200);
})->middleware('web');


Route::get('/{vue_capture?}', function () {
    return view('app');
})->where('vue_capture', '[\/\w\.-]*');
