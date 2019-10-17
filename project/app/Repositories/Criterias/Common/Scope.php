<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class Scope extends Criteria
{
    private $scope;
    private $value;

    public function __construct($scope, $value = null)
    {
        $this->scope = $scope;
        $this->value = $value;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->{$this->scope}($this->value);
    }
}
