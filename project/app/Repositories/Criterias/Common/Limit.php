<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class Limit extends Criteria
{
    private $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->limit($this->limit);
    }
}
