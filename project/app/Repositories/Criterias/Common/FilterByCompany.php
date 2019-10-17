<?php
namespace App\Repositories\Criterias\Common;


use Illuminate\Support\Facades\Input;

use App\Base\Criteria;
use App\Base\Repository;

class FilterByCompany extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $company = Input::get('company_id') ?? null;

        return (!!$company)
            ? $queryBuilder->where('company_id', $company)
            : $queryBuilder;
    }
}
