<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'user-notifications.'.$this->id;
    }

    public function friends()
    {
        return $this->belongsToMany(User::class ,'user_friends', 'user_id', 'friend_id');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_friends', 'user_id', 'chat_id');
    }
}
