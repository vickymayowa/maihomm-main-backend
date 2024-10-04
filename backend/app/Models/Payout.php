<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id");
    }

    public function scopeSearch($query, $value)
    {
        return $query->whereRaw("CONCAT(reference,' ', amount) LIKE ?", ["%$value%"]);
    }
}
