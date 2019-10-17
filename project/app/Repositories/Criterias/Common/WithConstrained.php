<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WithConstrained extends Criteria
{
    private $function;
    private $relationship;

    public function __construct($relationship, \Closure $function)
    {
        $this->function = $function;
        $this->relationship = $relationship;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->with([
            $this->relationship => $this->function
        ]);
    }
}
