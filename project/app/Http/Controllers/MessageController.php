<?php

namespace App\Http\Controllers;

use App\Base\PaginationBuilder;
use App\Http\Resources\MessageResource;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function pagination($chatId)
    {
        $pagination = new PaginationBuilder();

        $pagination->repository(MessageRepository::class)
            ->criterias([new Where('chat_id', $chatId)])
            ->resource(MessageResource::class)
            ->perPage(10);

            return $pagination->build();
    }
}
