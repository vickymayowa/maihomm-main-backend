<?php

namespace App\QueryBuilders\Finance;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanQueryBuilder
{
    public static function filterList(Request $request){
        $builder = Loan::with("user");

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
