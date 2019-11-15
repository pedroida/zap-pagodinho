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
        return [
            'id' => $this->id,
            'friend_name' => $this->friends->where('id', '<>', current_user()->id)->first()->name,
            'last_message' => optional($this->messages->last())->content ?? __('phrases.no_messages'),
        ];
    }
}
