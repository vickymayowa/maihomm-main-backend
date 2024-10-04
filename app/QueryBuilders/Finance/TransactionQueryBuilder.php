<?php

namespace App\QueryBuilders\Finance;

use App\Models\UserTransaction;
use App\Models\UserTransactionModel;
use Illuminate\Http\Request;

class TransactionQueryBuilder
{
    public static function filterList(Request $request)
    {
        $builder = UserTransaction::with("currency");

        if (!empty($key = $request->user_id)) {
            $builder = $builder->where('user_id', $key);
        } else {
            $builder = $builder->byUsers();
        }

        if (!empty($key = $request->type)) {
            $builder = $builder->where('type', $key);
        }

        if (!empty($key = $request->currency_id)) {
            $builder = $builder->where('currency_id', $key);
        }

        if (!empty($key = $request->activity)) {
            $builder = $builder->where('activity', $key);
        }


        $filter_type = $request->filter;

        if(empty($filter_type)){
            if (!empty($key = $request->search)) {
                $builder = $builder->search($key);
            }
        }
        else{
            $key = $request->search;

            if($filter_type == "ref_code"){
                $builder = $builder->where("ref_code", $key);
            }

            if($filter_type == "username"){
                $builder = $builder->whereHas("user", function ($query) use ($key) {
                    $query->where("username", $key);
                });
            }
            if($filter_type == "currency_type"){
                $builder = $builder->whereHas("currency", function ($query) use ($key) {
                    $query->where("type", $key);
                });
            }
        }

        return $builder;
    }
}
