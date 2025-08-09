<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\GetMessageChannel;
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

    public function review_getMessagesByChannel(Channel $channel) {
        # Мы получаем все сообщения, как я понимаю из твоего запроса, а не каналы
        # Исходя из твоей логики я понимаю, что должно быть получения таким образом
        # У тебя должен быть бургер: Канал > Сообщения + Пользователи
        # Ты на стороне клиента берешь и собираешь этот бургер соединяя пользователя и его сообщения

        # Создание ресурса: php artisan make:resource NameResource
        return GetMessageChannel::make($channel);
    }

    /**
     * Метод отправки сообщений
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(StoreRequest $request) {
        $user = auth()->user();
        # Чтобы не заполнять user_id используем создания сообщений из модели User
        $message = $user->messages()->create($request->validated());
        // отправка сообщения по вебсокету
        MessageBroadcast::dispatch($message);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Метод удаления сообщения
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMyMessage(Message $message) {
        if ($message->user_id == auth()->id())
            return response()->json(['status' => 'not owner']);

        $message->delete();
        return response()->json(['status' => 'ok']);
    }
}
