<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
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
}
