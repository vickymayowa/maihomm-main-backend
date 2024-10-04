<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function cart(){
        return $this->belongsTo(Cart::class , "cart_id");
    }

    public function property(){
        return $this->belongsTo(Property::class , "property_id");
    }

    public function getPrice(){
        return $this->property->getPrice();
    }

    public function getSubtotal(){
        return $this->total;
    }

}
