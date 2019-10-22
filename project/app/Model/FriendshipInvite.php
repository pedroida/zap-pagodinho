<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FriendshipInvite extends Model
{
    protected $table = 'friendship_invites';

    protected $fillable = [
        'user_id',
        'inviter_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }
}