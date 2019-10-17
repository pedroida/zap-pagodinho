<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class SelectLog extends Criteria
{

    private $id;
    private $values;

    public function __construct($id, $values)
    {
        $this->id = $id;
        $this->values = $values;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        try {
            return $queryBuilder
                ->withTrashed()
                ->where('id', $this->id)
                ->select($this->values);
        } catch(\Exception $e) {
            return $queryBuilder
                ->where('id', $this->id)
                ->select($this->values);
        }
    }
}
