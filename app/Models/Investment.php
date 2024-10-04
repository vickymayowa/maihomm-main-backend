<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id")->withTrashed();
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, "portfolio_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, "payment_id", "id");
    }

    public function scopeFilterByStatus($query, $value)
    {
        return $query->where("status", $value);
    }

    public function scopeFilterByDateRange($query, array $data)
    {
        $from = Carbon::createFromFormat('Y-m-d', $data["from"])->startOfDay();
        $to = Carbon::createFromFormat('Y-m-d', $data["to"])->endOfDay();
        return $query->whereBetween("created_at", [$from, $to]);
    }

    public function scopeSearch($query, $value)
    {
        return $query->whereHas("user", function ($q) use ($value) {
            $q->whereRaw("CONCAT(first_name,' ', middle_name , ' ', ' ' ,last_name) LIKE ?", ["%$value%"]);
        })
            ->whereRaw("CONCAT(value,' ', rate , ' ', ' ' ,status) LIKE ?", ["%$value%"]);
    }
}
