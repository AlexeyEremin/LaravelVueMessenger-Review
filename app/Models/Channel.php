<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = ['id'];

    # Всегда получаем из канала messages и users
    protected $with = ['messages', 'users'];

    /**
     * ПОлучение пользователей канала
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'channels_users');
    }

    /**
     * Получаю все сообщения канала
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(Message::class);
    }

    /**
     * Проверка принадлежности аккаунта к каналу
     * @param User $user
     * @return bool
     */
    public function isMember(User $user) {
        // является ли пользователь участником текущего чата
        return $this->users()->where('users.id', $user->id)->exists();
    }

}
