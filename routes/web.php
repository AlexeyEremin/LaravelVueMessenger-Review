<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

# Не понял момент связанный с тем, зачем prefix  API?
# Используем файл routes/api.php - он специально реализован для API
Route::prefix('api')->middleware('auth:sanctum')->group(function () {

    /*
     * Это конечно придирка, но зачем channels/me ?
     * Может проще channels?
     * У тебя же не зарезервивана данная ссылка
     */
    Route::get('/channels/me', [ChannelController::class, 'getMyChannels']);

    # Поиск канала лучше вынести в post запрос, чтобы данные передавались в Body, так как строка не бесконечная у ссылки
    Route::get('/channels/search/{query}', [ChannelController::class, 'searchChannel']);
    Route::post('/channels/join/{channel}', [ChannelController::class, 'joinChannel']);
    # Зачем в конце messages / ???
    Route::get('/channels/{channel}/messages/', [MessageController::class, 'getMessagesByChannel']);

    /*
     * Тут категорически не согласен, нужно создать единый метод создания каналов
     * Передавать в body параметры между пользователями или общий
     * Так же и ID пользователей
     */
    Route::post('/channels/local/{user}', [ChannelController::class, 'createLocalChannel']);

    /*
     * Так же хочу видеть поиск через body, а не query запрос
     */
    Route::get('/users/search/{query}', [UserController::class, 'searchUserByName']);
    # Это что? Много пользователей, и я смотрю себя? Может лучше user/me
    Route::get('/users/me', [UserController::class, 'getMe']);
    Route::post('/channels', [ChannelController::class, 'createChannel']);
    Route::delete('/messages/{message}', [MessageController::class, 'deleteMyMessage']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);
});
