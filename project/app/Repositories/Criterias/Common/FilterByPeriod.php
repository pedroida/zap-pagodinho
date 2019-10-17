<?php

namespace App\Repositories\Criterias\Common;

use Illuminate\Support\Facades\Input;

use App\Base\Criteria;
use App\Base\Repository;

class FilterByPeriod extends Criteria
{
    private $field;
    private $period;
    private $relation;

    public function __construct($relation, $field, $period = null)
    {
        $this->period = $period ?? Input::get('period') ?? null;
        $this->relation = $relation;
        $this->field = $field;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return !is_null($this->period)
            ? $this->getDataByPeriod($queryBuilder)
            : $queryBuilder;
    }

    private function getDataByPeriod($queryBuilder)
    {
        $field = $this->field;
        $dateInterval = convert_date_interval($this->period);

        return $queryBuilder->whereHas($this->relation,
            function ($query) use ($dateInterval, $field) {
                return $query->whereBetween($field, $dateInterval);
            });
    }
}
