<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = [];

    public function referrer()
    {
        return $this->belongsTo(User::class , "referrer_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class , "user_id");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class , "currency_id");
    }

}
