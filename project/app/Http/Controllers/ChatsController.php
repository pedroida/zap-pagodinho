<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyChatResource;
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

        return MyChatResource::make($chat);
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

    public function myChats()
    {
        $chats = current_user()->chats()->with(['friends', 'messages'])->orderBy('updated_at', 'desc');

        $search = \request()->get('friend_name');

        if ($search)
            $chats->whereHas('friends', function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%");
            });

        return MyChatResource::collection($chats->get());
    }

    public function destroy($chatId)
    {
        try {
            (new ChatRepository())->delete($chatId);

            return response()->json([
                'type' => 'success',
                'message' =>  __('flash.chat.success.destroy')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' =>  __('flash.chat.error.destroy')
            ]);
        }
    }
}