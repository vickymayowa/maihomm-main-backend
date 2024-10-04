<?php

namespace App\QueryBuilders\General;

use App\Models\Booking;
use App\Models\User;
use App\Models\WalletFundProof;
use Illuminate\Http\Request;

class ProofQueryBuilder
{
    public static function filterList(Request $request)
    {
        $builder = new WalletFundProof;

        if (!empty($key = $request->search)) {
            $builder = $builder->search($key);
        }

        if (!empty($key = $request->status)) {
            $builder = $builder->where("status", $key);
        }

        return $builder;
    }
}
