<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{

    protected $guarded = [];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function markAsRead(){
        $this->read_at = Carbon::now();
        $this->save();
    }
}
