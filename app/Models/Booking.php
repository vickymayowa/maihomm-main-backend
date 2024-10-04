<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id");
    }

    public function scopeSearch($query, $value)
    {
        // return $query->whereHas("user", function ($q) use ($value) {
        //     $q->whereRaw("CONCAT(first_name,' ', middle_name , ' ', ' ' ,last_name) LIKE ?", ["%$value%"]);
        // })
        //     ->whereRaw("CONCAT(reference,' ', slots) LIKE ?", ["%$value%"]);

        return $query->where(function ($sub) use ($value) {
            $sub->whereHas("property", function ($q) use ($value) {
                $q->whereRaw("CONCAT(name,' ', description ) LIKE ?", ["%$value%"]);
            })
                ->orWhereRaw("CONCAT(reference) LIKE ?", ["%$value%"]);
        });
    }
}
