<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
        $friendName = $this->friends->where('id', '<>', current_user()->id)->first()->name;
        return [
            'id' => $this->id,
            'friend_name' => Str::limit($friendName, 20, ' ...'),
            'last_message' => optional($lastMessage)->content ?? __('phrases.no_messages'),
            'last_message_type' => optional($lastMessage)->content_type,
            'last_message_created_at' => ($lastMessage) ? format_date($lastMessage->created_at) : '',
        ];
    }
}
