<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChannelUser extends Pivot
{
    protected $table = 'channels_users';
}
