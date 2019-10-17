<?php
namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WhereBetweenIntervalCriteria extends Criteria
{
    private $interval;
    private $columnName;
    private $onRelationship;

    public function __construct(
        ?string $interval,
        string $columnName = 'created_at',
        string $onRelationship = null
    ) {
        $this->columnName = $columnName;
        $this->interval = (!! $interval)
            ? convert_date_interval($interval)
            : null;
        $this->onRelationship = $onRelationship;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        if (!$this->interval) {
            return $queryBuilder;
        }

        if (!$this->onRelationship) {
            return $queryBuilder->whereBetween($this->columnName, $this->interval);
        }

        return $queryBuilder->whereHas($this->onRelationship, function ($query) {
            return $query->whereBetween($this->columnName, $this->interval);
        });
    }
}
