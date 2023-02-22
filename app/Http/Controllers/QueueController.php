<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QueuedTrack;

use App\Helpers\SpotifyClient;

class QueueController extends Controller
{
    public function get()
    {
        $queue = QueuedTrack::where('user_id', auth()->user()->id)->get();
        
        return $queue->map->only(['id', 'name', 'uri', 'artist', 'image', 'image_thumb', 'added_at'])->toJson();
    }

    public function add(Request $request)
    {
        // TODO: Validation
        $queueId = $request->id;
        $user = auth()->user();

        try {
            $queueTrack = QueuedTrack::where('user_id', $user->id)->where('id', $queueId)->firstOrFail();

            $params = array(
                'uri'   => "spotify:track:" . $queueTrack->uri
            );

            $spotifyClient = new SpotifyClient($params);

            $spotifyClient->addToQueue();

            $queueTrack->update([ 'added_at' => now() ]);
            $queueTrack->delete(); // Soft Delete
        } catch (\Throwable $e) {
            \Log::info($e);
            return response()->json([
                'error'      => 'Unable to add track to queue',
            ], 400);
        }

        return response()->json([
            'success'      => 'Track added to queue',
        ], 200);
    }

    public function remove(Request $request)
    {
        $queueId = $request->id;
        $user = auth()->user();

        try {
            $queueTrack = QueuedTrack::where('user_id', $user->id)->where('id', $queueId)->firstOrFail();
            $queueTrack->delete(); // Soft Delete
        } catch (\Throwable $e) {
            return response()->json([
                'error'      => 'Unable to remove track from queue',
            ], 400);
        }

        return response()->json([
            'success'      => 'Track removed from queue',
        ], 200);
    }
}
