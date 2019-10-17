<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class Select extends Criteria
{
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->select(...$this->values);
    }
}
