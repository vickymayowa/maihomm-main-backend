<?php

namespace App\QueryBuilders\General;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyQueryBuilder
{
    static function filterIndex(Request $request, array $with = [])
    {
        $builder =  new Property;

        if (!empty($with)) {
            $builder = $builder->with($with);
        }

        if (!empty($key = $request->status)) {
            $builder = $builder->filterByStatus($key);
        }

        if (!empty($key = $request->search)) {
            $builder = $builder->search($key);
        }

        if (!empty($key = $request->location)) {
            $builder = $builder->whereRaw("CONCAT(address) LIKE ?", ["%$key%"]);
        }

        if (!empty($key = $request->price_from)) {
            $builder = $builder->where("price", "<=", $key);
        }

        if (!empty($key = $request->price_to)) {
            $builder = $builder->where("price", ">=", $key);
        }

        if (!empty($key = $request->amenity_ids)) {
            $builder = $builder->whereHas("amenities", function ($q) use ($key) {
                $q->whereIn("amenity_id", $key);
            });
        }


        return $builder;
    }
}
