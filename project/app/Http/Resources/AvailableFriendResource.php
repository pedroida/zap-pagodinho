<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailableFriendResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,

            'updated_at' => format_date($this->updated_at),
            'created_at' => format_date($this->created_at),

            'links' => [
                'send_invite' => route('ajax.send.friendship-invite', $this->id)
            ]
        ];
    }
}
