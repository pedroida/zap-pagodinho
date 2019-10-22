<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Model\FriendshipInvite;

class FriendshipInviteRepository extends Repository
{
    protected function getClass()
    {
        return FriendshipInvite::class;
    }
}