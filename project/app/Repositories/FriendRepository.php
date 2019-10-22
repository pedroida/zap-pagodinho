<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Model\User;

class FriendRepository extends Repository
{
    protected function getClass()
    {
        return User::class;
    }
}