<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Если мы заполняем все поля, не пиши fillable
     * guarded твое спасение, защити только id и все не трать время на все поля
     * @var string[]
     */
    protected $guarded = ['id'];

    ###### Добавляем комментарии обязательно!!!! ######

    /**
     * Получение модели пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Получение модели канала
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel() {
        return $this->belongsTo(Channel::class);
    }
}
