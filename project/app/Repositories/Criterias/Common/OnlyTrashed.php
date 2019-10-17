<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class OnlyTrashed extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->onlyTrashed();
    }
}
