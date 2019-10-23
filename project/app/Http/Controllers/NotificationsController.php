<?php

namespace App\Http\Controllers;

use App\Http\Resources\InviteNotificationResource;
use App\Http\Resources\MessageNotificationResource;
use App\Repositories\Criterias\Common\OrderBy;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\FriendshipInviteRepository;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function getInvites()
    {
        $invites = (new FriendshipInviteRepository())->pushCriteria([
            new Where('user_id', current_user()->id),
            new OrderBy('updated_at', 'desc')
        ])->all();

        return InviteNotificationResource::collection($invites);
    }

    public function getMessages()
    {
        return MessageNotificationResource::collection(collect());
    }
}
