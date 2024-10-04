<?php

namespace App\QueryBuilders\Finance;

use App\Models\Loan;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewQueryBuilder
{
    public static function filterList(Request $request){
        $builder = Review::with(["user" , "property"]);

        if(!empty($key = $request->time_order)){
            $builder = $builder->timeOrder($key);
        }
        return $builder;
    }
}
