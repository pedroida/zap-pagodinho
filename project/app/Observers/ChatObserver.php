<?php

namespace App\Observers;

use App\Events\ChatDestroyed;
use App\Model\Chat;

class ChatObserver
{
    /**
     * Handle the chat "deleted" event.
     *
     * @param Chat $chat
     * @return void
     */
    public function deleted(Chat $chat)
    {
        $chat->friends->each(function ($friend) use($chat){
           event(new ChatDestroyed($chat->id, $friend->id));
        });
    }
}
