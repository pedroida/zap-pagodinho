<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class With extends Criteria
{
    private $relationship;

    public function __construct($relationship)
    {
        $this->relationship = $relationship;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->with($this->relationship);
    }
}
