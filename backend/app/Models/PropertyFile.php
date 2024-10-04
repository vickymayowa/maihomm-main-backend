<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class PropertyFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function file()
    {
        return $this->belongsTo(File::class, "file_id");
    }

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id");
    }

    public function scopeType($query, $type){
        return $query->where("type", $type);
    }
}
