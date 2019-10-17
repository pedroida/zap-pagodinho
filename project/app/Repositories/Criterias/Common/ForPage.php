<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class ForPage extends Criteria
{
    private $page;
    private $perPage;

    public function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->forPage($this->page, $this->perPage);
    }
}
