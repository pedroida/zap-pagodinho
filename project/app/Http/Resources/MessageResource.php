<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'chat_id' => $this->chat_id,
            'content_type' => $this->content_type,
            'created_at' => format_date($this->created_at),
            'is_my_message' => $this->user_id == current_user()->id,
        ];
    }
}
