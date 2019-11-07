<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    public function friends()
    {
        return $this->belongsToMany(User::class, 'chat_friends', 'user_id', 'chat_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}