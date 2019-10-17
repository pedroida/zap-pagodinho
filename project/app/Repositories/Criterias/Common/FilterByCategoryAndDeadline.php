<?php
namespace App\Repositories\Criterias\Common;

use Illuminate\Support\Facades\Input;

use App\Base\Criteria;
use App\Base\Repository;

class FilterByCategoryAndDeadline extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $categories = Input::get('category_id') ?? null;
        if (!is_null($categories)) {
            $categoriesId = explode(',', $categories);
            $queryBuilder = $queryBuilder->whereIn('category_id', $categoriesId);
        }

        $startDate = Input::get('start_date') ?? null;
        if (!is_null($startDate)) {
            $queryBuilder = $queryBuilder
                ->where('deadline', '>=', format_date($startDate, 'Y-m-d', format_of_date()));
        }

        $endDate = Input::get('end_date') ?? null;
        if (!is_null($endDate)) {
            $queryBuilder = $queryBuilder
                ->where('deadline', '<=', format_date($endDate, 'Y-m-d', format_of_date()));
        }

        $period = (Input::get('period') == 'undefined' ? null : Input::get('period')) ?? null;
        if (!is_null($period)) {
            $formattedDate = convert_date_interval($period);
            $queryBuilder = $queryBuilder->whereBetween('created_at', $formattedDate);
        }

        return $queryBuilder;
    }
}
