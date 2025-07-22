<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageBroadcast;

class MessageController extends Controller
{
    public function getMessagesByChannel(Request $request, Channel $channel) {
        // получение всех каналов пользователя
        return Message::with('user:id,name') // Жадная загрузка только нужных полей
        ->where('channel_id', $channel->id)
        ->get()
        ->map(function ($message) {
            return [
                'id' => $message->id,
                'content' => $message->content,
                'created_at' => $message->created_at,
                'author' => $message->user->name // Добавляем имя пользователя
            ];
        });
    }
    public function sendMessage(Request $request) {
        // отправка соощения
        $validated = $request->validate(['message' => 'string|min:1', 'channel_id' => 'exists:channels,id']);
        $user = $request->user();
        $msg = Message::create(['content' => $validated['message'], 'channel_id' => $validated['channel_id'], 'user_id' => $user->id]);
        // отправка сообщения по вебсокету
        MessageBroadcast::dispatch($msg);

        return response()->json(['status' => 'ok'], 200);
    }

    public function deleteMyMessage(Request $request, Message $message) {
        // удаление своего сообщения
        $user = $request->user();
        // проврека принадлежности сообщения
        if ($message->user_id != $user->id) {
            return response()->json(['status' => 'not owner'], 200);
        }
        $message->delete();
        return response()->json(['status' => 'ok'], 200);
    }
}
