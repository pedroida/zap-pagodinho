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
        return [
            'id' => $this->id,
            'is_group' => $this->is_group,
            'name' => $this->getChatName(),
            'friends_name' => $this->getFriendsName(),
            'last_message' => optional($lastMessage)->content ?? __('phrases.no_messages'),
            'last_message_type' => optional($lastMessage)->content_type ?? 'text',
            'last_message_created_at' => ($lastMessage) ? format_date($lastMessage->created_at) : '',
        ];
    }

    private function getChatName()
    {
        if ($this->name)
            return Str::limit($this->name, 20, ' ...');

        $friendName = $this->friends->where('id', '<>', current_user()->id)->first()->name;
        return Str::limit($friendName, 20, ' ...');
    }

    private function getFriendsName()
    {
        return $this->naturalLanguageJoin($this->friends->map(function ($friend) {
            if ($friend->id === current_user()->id)
                return 'você';

            return $friend->name;
        })->toArray(), 'e');
    }

    private function naturalLanguageJoin(array $list, $conjunction = 'and') {
        $last = array_pop($list);
        if ($list) {
            return implode(', ', $list) . ' ' . $conjunction . ' ' . $last;
        }
        return $last;
    }
}
