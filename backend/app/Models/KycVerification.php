<?php

namespace App\Models;

use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $fillable = [
    //     'user_id', 'id_type', 'nin', 'nationality'
    // ];
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function isVerified()
    {
        return $this->status == StatusConstants::VERIFIED;
    }
}
