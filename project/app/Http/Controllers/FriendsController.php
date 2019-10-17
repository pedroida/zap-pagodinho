<?php

namespace App\Http\Controllers;

use App\Base\PaginationBuilder;
use App\Http\Resources\FriendResource;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\UserRepository;

class FriendsController extends Controller
{
    public function index()
    {
        return view('friends.index');
    }

    public function pagination()
    {
        $pagination =  new PaginationBuilder();

        $pagination->repository(UserRepository::class)
            ->criterias(new Where('id', current_user()->id))
            ->resource(FriendResource::class)
            ->perPage(20);

        return $pagination->build();
    }
}