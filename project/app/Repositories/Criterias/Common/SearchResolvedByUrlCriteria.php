<?php
namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;
use Illuminate\Support\Facades\Request;

class SearchResolvedByUrlCriteria extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $params = Request::all();
        if (!data_get($params, 'query')) {
            return $queryBuilder;
        }

        $query = $params['query'];

        $queryBuilder->search($query);

        return $queryBuilder;
    }
}
