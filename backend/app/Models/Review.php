<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id");
    }
    
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function scopetimeOrder($query, $value)
    {
        if ($value == "newest") {
            $builder = $query->latest("created_at");
        } else {
            $builder = $query->oldest("created_at");
        }

        return $builder;
    }
}
