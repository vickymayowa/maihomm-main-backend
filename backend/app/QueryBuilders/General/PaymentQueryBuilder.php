<?php

namespace App\QueryBuilders\General;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;

class PaymentQueryBuilder
{       
    static function filterIndex(Request $request)
    {
        $builder = new Payment;

        // if (!empty($with)) {
        //     $builder = $builder->with($with);
        // }

        // if (!empty($key = $request->search)) {
        //     $builder = $builder->($key);
        // }

        return $builder;
    }
}
