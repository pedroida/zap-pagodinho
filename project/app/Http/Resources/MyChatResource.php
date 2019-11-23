<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lastMessage = $this->messages->last();
        return [
            'id' => $this->id,
            'friend_name' => $this->friends->where('id', '<>', current_user()->id)->first()->name,
            'last_message' => optional($lastMessage)->content ?? __('phrases.no_messages'),
            'last_message_created_at' => ($lastMessage) ? format_date($lastMessage->created_at) : '',
        ];
    }
}
