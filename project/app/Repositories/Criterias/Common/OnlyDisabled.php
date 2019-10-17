<?php
namespace App\Repositories\Criterias\Common;



use App\Base\Criteria;
use App\Base\Repository;

class OnlyDisabled extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->where('is_active', false);
    }
}
