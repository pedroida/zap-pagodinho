<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InviteNotificationResource extends JsonResource
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
            'inviter_name' => $this->inviter->name,

            'links' => [
                'accept' => route('ajax.invite.accept', $this->id),
                'decline' => route('ajax.invite.decline', $this->id),
            ]
        ];
    }
}
