<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class ManualSupplier extends Criteria
{
    private $cnpj;
    private $companyId;

    public function __construct($cnpj, $companyId)
    {
        $this->cnpj = $cnpj;
        $this->companyId = $companyId;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder
            ->where('cnpj', $this->cnpj)
            ->where('indicated_by_id', $this->companyId)
            ->where('is_manual_register', true);
    }
}
