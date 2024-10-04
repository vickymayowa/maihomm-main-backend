<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function icon()
    {
        return $this->belongsTo(File::class, "icon_id");
    }
}
