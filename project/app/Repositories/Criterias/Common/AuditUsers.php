<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class AuditUsers extends Criteria
{

    private $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder
            ->whereNotNull('causer_id')
            ->whereIn('causer_id', $this->users);
    }
}
