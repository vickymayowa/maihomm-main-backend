<?php

namespace App\Models;

use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentFile extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function isComplete()
    {
        return $this->status == StatusConstants::COMPLETED;
    }

    public function user()
    {
        return $this->belongsTo(User::class , "user_id" , "id");
    }


    public function property()
    {
        return $this->belongsTo(Property::class , "property_id" , "id");
    }

    public function file()
    {
        return $this->belongsTo(File::class , "file_id" , "id");
    }
}
