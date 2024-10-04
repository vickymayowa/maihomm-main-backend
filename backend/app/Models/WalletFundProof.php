<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletFundProof extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function file(){
        return $this->belongsTo(File::class, "file_id");
    }

    public function wallet(){
        return $this->belongsTo(Wallet::class, "wallet_id");
    }
}

