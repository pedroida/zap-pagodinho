<?php

namespace App\Http\Controllers;

use App\Base\PaginationBuilder;
use App\Events\FriendshipInviteAccepted;
use App\Events\FriendshipInviteDeclined;
use App\Events\NewFriendshipInvite;
use App\Http\Resources\AvailableFriendResource;
use App\Http\Resources\FriendResource;
use App\Model\User;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\Criterias\Common\WhereDoesntHave;
use App\Repositories\Criterias\Common\WhereHas;
use App\Repositories\Criterias\Common\WhereIn;
use App\Repositories\Criterias\Common\WhereNotIn;
use App\Repositories\Criterias\Common\With;
use App\Repositories\FriendRepository;
use App\Repositories\FriendshipInviteRepository;
use App\Repositories\UserRepository;

class FriendsController extends Controller
{
    public function index()
    {
        return view('friends.index');
    }

    public function sendFriendshipInvite($userId)
    {
        try {
            (new FriendshipInviteRepository())->create([
               'inviter_id' => current_user()->id,
               'user_id' => $userId,
            ]);

            event(new NewFriendshipInvite($userId));

            return response()->json([
                'type' => 'success',
                'message' =>  __('flash.send_invite.success')
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'type' => 'error',
                'message' =>  __('flash.send_invite.error')
            ]);
        }
    }

    public function acceptInvite($inviteId)
    {
        $invite = (new FriendshipInviteRepository())->find($inviteId);

        try {
            $invite->inviter->friends()->attach(['friend_id' => current_user()->id]);
            current_user()->friends()->attach(['friend_id' => $invite->inviter_id]);

            event(new FriendshipInviteAccepted($invite->inviter_id, $invite->user->name));
            $invite->delete();

            return response()->json([
                'type' => 'success',
                'message' => __('flash.invite.success.accept')
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
               'type' => 'error',
               'message' => __('flash.invite.error.accept')
            ]);
        }
    }

    public function declineInvite($inviteId)
    {
        $invite = (new FriendshipInviteRepository())->find($inviteId);

        try {
            $invite->delete();
            event(new FriendshipInviteDeclined($invite->inviter_id, $invite->user->name));

            return response()->json([
                'type' => 'success',
                'message' => __('flash.invite.success.decline')
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'type' => 'error',
                'message' => __('flash.invite.error.decline')
            ]);
        }
    }

    public function availableNewFriends()
    {
        $notAvailable = (new FriendshipInviteRepository())->pushCriteria([
            new Where('inviter_id', current_user()->id)
        ])->pluck('user_id');
        $notAvailable->merge(current_user()->friends->pluck('id'));
        $notAvailable->push(current_user()->id);

        $availableFriends = (new UserRepository())->pushCriteria([
            new WhereNotIn('id', $notAvailable->unique())
        ])->all();

        return AvailableFriendResource::collection($availableFriends);
    }


    public function pagination()
    {
        $pagination =  new PaginationBuilder();
        $currentUserFriends = current_user()->friends->pluck('id');
        $pagination->repository(FriendRepository::class)
            ->criterias([
                new WhereIn('id', $currentUserFriends)
            ])
            ->resource(FriendResource::class)
            ->perPage(10);

        return $pagination->build();
    }
}