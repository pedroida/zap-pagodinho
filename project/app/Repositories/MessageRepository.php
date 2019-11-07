<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Model\Message;

class MessageRepository extends Repository
{
    protected function getClass()
    {
        return Message::class;
    }
}