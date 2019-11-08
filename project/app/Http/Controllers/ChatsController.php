<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewChatFriendAvailableResource;
use App\Repositories\ChatRepository;
use App\Repositories\Criterias\Common\WhereHas;
use App\Repositories\Criterias\Common\With;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function index()
    {
        return view('chats.index');
    }

    public function create(Request $request)
    {
        $chat = (new ChatRepository())->create([
            'owner_id' => current_user()->id,
        ]);

        $chat->friends()->sync([
            current_user()->id,
            $request->get('friend_id')
        ]);

        return $chat;
    }

    public function newChatsAvailable()
    {
        $userChatsFriends = (new ChatRepository())->pushCriteria([
            new WhereHas('friends', function ($query) {
                return $query->where('user_id', current_user()->id);
            }),
            new With('friends')
        ])->all()
        ->map->friends->flatten()->map->id;

        $friendsWithOpenedChat = $userChatsFriends->reject(function ($friend) {
            return $friend == current_user()->id;
        })->toArray();

        $friendAvailable = current_user()->friends->whereNotIn('id', $friendsWithOpenedChat);
        return NewChatFriendAvailableResource::collection($friendAvailable);
    }
}