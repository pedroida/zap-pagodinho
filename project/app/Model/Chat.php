<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = ['owner_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'chat_friends', 'chat_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}