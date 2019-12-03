<?php

namespace App\Http\Controllers;

use App\Base\PaginationBuilder;
use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\MessageRepository;

class MessageController extends Controller
{
    public function sendMessage(SendMessageRequest $request)
    {
        $message = $request->get('message');
        $chatId = $request->get('chat_id');
        $type = $request->get('type');

        $newChatMessage = (new MessageRepository())->create([
            'user_id' => current_user()->id,
            'chat_id' => $chatId,
            'content_type' => $type,
            'content' => $message,
        ]);

        return response()->json([
            'type' => 'success',
            'message' => $newChatMessage
        ], 201);
    }

    public function pagination($chatId)
    {
        $pagination = new PaginationBuilder();

        $pagination->repository(MessageRepository::class)
            ->criterias([new Where('chat_id', $chatId)])
            ->resource(MessageResource::class)
            ->defaultOrderBy('created_at', 'desc')
            ->perPage(10);

        return $pagination->build();
    }
}
