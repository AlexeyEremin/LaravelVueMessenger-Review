<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'title'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'channels_users');
    }

    public function isMember(User $user) {
        // является ли пользователь участником текущего чата
        return $this->users()->where('users.id', $user->id)->exists();
    }

}
