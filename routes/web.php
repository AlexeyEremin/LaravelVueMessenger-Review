<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    Route::get('/channels/me', [ChannelController::class, 'getMyChannels']);
    Route::get('/channels/search/{query}', [ChannelController::class, 'searchChannel']);
    Route::post('/channels/join/{channel}', [ChannelController::class, 'joinChannel']);
    Route::get('/channels/{channel}/messages/', [MessageController::class, 'getMessagesByChannel']);
    Route::post('/channels/local/{user}', [ChannelController::class, 'createLocalChannel']);
    Route::get('/users/search/{query}', [UserController::class, 'searchUserByName']);
    Route::get('/users/me', [UserController::class, 'getMe']);
    Route::post('/channels', [ChannelController::class, 'createChannel']);
    Route::delete('/messages/{message}', [MessageController::class, 'deleteMyMessage']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);
});