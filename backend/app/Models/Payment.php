<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, "transaction_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }


    public function files()
    {
        return $this->hasMany(PaymentFile::class, "payment_id", "id");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, "currency_id", "id");
    }

    public function scopeSearch($query, $value)
    {
        $query->whereRaw("CONCAT(reference) LIKE ?", ["%$value%"])
            ->orwhereHas('user', function (Builder $query) use ($value) {
                $query->whereRaw('CONCAT(first_name, " ", last_name) LIKE?', ["%$value%"]);
            })->orWhereHas('workspace', function (Builder $query) use ($value) {
                $query->where('name', 'LIKE', "%$value%");
            });
    }

    public function scopeToday($query)
    {
        $start_time = Carbon::now()->startOfDay();
        $end_time = $start_time->copy()->endOfDay();

        return $query->whereBetween('created_at', [$start_time, $end_time]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getAmount($column)
    {
        return $this->currency->short_name."".$this->$column;
    }

    public function investments()
    {
        return $this->hasMany(Investment::class, "payment_id", "id");
    }
}
