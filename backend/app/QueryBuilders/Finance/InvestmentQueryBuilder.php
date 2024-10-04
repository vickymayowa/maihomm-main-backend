<?php

namespace App\QueryBuilders\Finance;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentQueryBuilder
{
    public static function filterList(Request $request){
        $builder = Investment::with("property");

        if(!empty($key = $request->status)){
            $builder = $builder->filterByStatus($key);
        }

        if(!empty($request->from) && !empty($request->to)){
            $dates = [
                "from" => $request->from,
                "to" => $request->to
            ];
            $builder = $builder->FilterByDateRange($dates);
        }

        return $builder;
    }
}
