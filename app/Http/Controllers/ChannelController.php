<?php

namespace App\Http\Controllers;

use App\Http\Requests\Channel\StoreRequest;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Получения каналов пользователя
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|object
     */
    public function getMyChannels()
    {
        return response(auth()->user()->channels);
    }

    /**
     * Создания канала
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createChannel(StoreRequest $request) {
        $channel = Channel::create($request->validated());
        auth()->user()->channels()->save($channel);

        # Не ставь стандартные дефольные значения такие как 200
        return response()->json(['data' => $channel, 'status' => 'ok']);
    }

    /**
     * Метод создания чата для двух человек
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function createLocalChannel(User $user) {
        $currentUser = auth()->user();
        $channel = Channel::create(['title' => $currentUser->name . ' and ' . $user->name]);
        $currentUser->channels()->save($channel);
        $user->channels()->save($channel);
        return response()->json(['data' => $channel, 'status' => 'ok']);
    }

    /**
     * Поиск каналов, но я думаю что должно быть через POST
     * @param string $query
     * @return mixed
     */
    public function searchChannel(string $query) {
        // поиск канала по названию
        $invitedChannelIds = auth()->user()->channels->pluck('id');

        # Но почему у тебя всего 15, а если 20?
        return Channel::whereLike('title', '%' . $query . '%')->whereNotIn('id', $invitedChannelIds)->limit(15)->get();
    }

    /**
     * @param Channel $channel
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinChannel(Channel $channel) {
        // присоединение текущего пользователя к каналу
        $user = auth()->user();

        // А почему мы в канале ищем? А не у пользователя данный канал?
        if ($channel->isMember($user)) {
            return response()->json(['status' => 'already member']);
        }

        $channel->users()->save($user);
        return response()->json(['status' => 'ok']);
    }
}
