<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getMyChannels(Request $request)
    {
        return $request->user()->channels;
    }

    public function createChannel(Request $request) {
        $validated = $request->validate([
            'title' => 'string|min:3|unique:channels'
        ]);
        $user = $request->user();
        $channel = Channel::create(['title' => $validated['title']]);
        $user->channels()->save($channel);
        return response()->json(['data' => $channel, 'status' => 'ok'], 200);
    }

    public function createLocalChannel(Request $request, User $user) {
        $current_user = $request->user();
        $channel = Channel::create(['title' => $current_user->name . ' and ' . $user->name]);
        $current_user->channels()->save($channel);
        $user->channels()->save($channel);
        return response()->json(['data' => $channel, 'status' => 'ok'], 200);
    }

    public function searchChannel(Request $request, string $query) {
        $user = $request->user();
        return Channel::whereLike('title', '%' . $query . '%')->whereNotIn('id', function ($q) use ($user) {
            $q->select('channel_id')->from('channels_users')->where('user_id', '=', $user->id);
        })->limit(15)->get();
    }

    public function joinChannel(Request $request, Channel $channel) {
        $user = auth()->user();

        if ($channel->isMember($user)) {
            return response()->json(['status' => 'already member'], 200);
        }

        $channel->users()->save($user);
        return response()->json(['status' => 'ok'], 200);
    }
}
