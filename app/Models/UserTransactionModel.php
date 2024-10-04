<?php

namespace App\Models;

use App\Constants\TransactionConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserTransactionModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class , "user_id" , "id");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class , "currency_id" , "id");
    }

    public function providerUserTransaction()
    {
        return $this->hasOne(ProviderUserTransaction::class ,"transaction_id", "id");
    }


    public function formattedAmount()
    {
        if($this->amount > 1000){
            return int_format($this->amount , 2);
        }
        return $this->amount;
    }


    public function scopeDebit($query){
        $query->where("type" , TransactionConstants::DEBIT);
    }

    public function scopeCredit($query){
        $query->where("type" , TransactionConstants::CREDIT);
    }

    public function scopeSearch($query , $value){
        $query->whereRaw("CONCAT(description,' ', reference) LIKE ?", ["%$value%"])
        ->orWhere("batch_no" , "like" , "%$value%");
    }

    public function scopeByUsers($query){
        $query->whereNotIn("user_id" , range(1, 3));
    }

    public function scopeByAdmins($query){
        $query->whereIn("user_id" , range(1, 3));
    }
}
