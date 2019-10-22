<?php

namespace App\Http\Controllers;

use App\Base\PaginationBuilder;
use App\Http\Resources\AvailableFriendResource;
use App\Http\Resources\FriendResource;
use App\Model\User;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\Criterias\Common\WhereDoesntHave;
use App\Repositories\Criterias\Common\WhereHas;
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

        $pagination->repository(FriendRepository::class)
            ->criterias([
                new WhereHas('friends', function ($query) {
                    return $query->where('user_id', current_user()->id);
                }),
            ])
            ->resource(FriendResource::class)
            ->perPage(10);

        return $pagination->build();
    }
}