<?php

namespace App\QueryBuilders\General;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingQueryBuilder
{
    public static function filterList(Request $request)
    {
        $builder = Booking::with(["user"]);

        if (!empty($key = $request->search)) {
            $builder = $builder->search($key);
        }

        if (!empty($key = $request->property_location)) {
            $builder = $builder->whereHas("property", function ($q) use ($key) {
                $q->whereRaw("CONCAT(address) LIKE ?", ["%$key%"]);
            });
        }

        if (!empty($key = $request->price_from)) {
            $builder = $builder->whereHas("property", function ($q) use ($key) {
                $q->where("price", "<=", $key);
            });
        }

        if (!empty($key = $request->price_to)) {
            $builder = $builder->whereHas("property", function ($q) use ($key) {
                $q->where("price", ">=", $key);
            });
        }

        if (!empty($key = $request->property_amenity_ids)) {
            $builder = $builder->whereHas("property", function ($q) use ($key) {
                $q->whereHas("amenities", function ($q) use ($key) {
                    $q->whereIn("amenity_id", $key);
                });
            });
        }


        return $builder;
    }
}
