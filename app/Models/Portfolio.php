<?php

namespace App\Models;

use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Portfolio extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    public function investments()
    {
        return $this->hasMany(Investment::class, "portfolio_id")->latest();
    }

    public function pendingInvestments()
    {
        return $this->hasMany(Investment::class, "portfolio_id")->where("status", StatusConstants::PENDING);
    }

    public function activeInvestments()
    {
        return $this->hasMany(Investment::class, "portfolio_id")->where("status", StatusConstants::ACTIVE);
    }

    public function loanEligibilityCalculator()
    {
        $active_inventments = array_sum($this->activeInvestments()->pluck("investment_cost")->toArray());
        $eligibilty_amount = ($active_inventments * 50) / 100;
        return $eligibilty_amount;
    }
}
