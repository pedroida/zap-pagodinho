<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Model\Chat;

class ChatRepository extends Repository
{
    protected function getClass()
    {
        return Chat::class;
    }
}