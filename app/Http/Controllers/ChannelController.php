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
        // получение каналов пользователя
        return $request->user()->channels;
    }

    public function createChannel(Request $request) {
        // создание канала
        $validated = $request->validate([
            'title' => 'string|min:3|unique:channels'
        ]);
        $user = $request->user();
        $channel = Channel::create(['title' => $validated['title']]);
        $user->channels()->save($channel);
        return response()->json(['data' => $channel, 'status' => 'ok'], 200);
    }

    public function createLocalChannel(Request $request, User $user) {
        // создание чата для 2 пользователей
        $current_user = $request->user();
        $channel = Channel::create(['title' => $current_user->name . ' and ' . $user->name]);
        $current_user->channels()->save($channel);
        $user->channels()->save($channel);
        return response()->json(['data' => $channel, 'status' => 'ok'], 200);
    }

    public function searchChannel(Request $request, string $query) {
        // поиск канала по названию
        $user = $request->user();
        // поиск каналов, где нет каналов пользователя
        return Channel::whereLike('title', '%' . $query . '%')->whereNotIn('id', function ($q) use ($user) {
            $q->select('channel_id')->from('channels_users')->where('user_id', '=', $user->id);
        })->limit(15)->get();
    }

    public function joinChannel(Request $request, Channel $channel) {
        // присоединение текущего пользователя к каналу
        $user = auth()->user();

        // не добавляется канал, если пользователь уже в нём
        if ($channel->isMember($user)) {
            return response()->json(['status' => 'already member'], 200);
        }

        $channel->users()->save($user);
        return response()->json(['status' => 'ok'], 200);
    }
}
