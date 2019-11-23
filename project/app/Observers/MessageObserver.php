<?php

namespace App\Observers;

use App\Model\Message;
use App\Notifications\NewMessageNotification;

class MessageObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param Message $message
     * @return void
     */
    public function created(Message $message)
    {
        $message->chat->friends->map(function ($user) use($message){
            $user->notify(new NewMessageNotification($message));
        });
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param Message $message
     * @return void
     */
    public function deleted(Message $message)
    {
        //
    }
}
