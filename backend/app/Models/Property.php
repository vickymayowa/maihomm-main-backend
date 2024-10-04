<?php

namespace App\Models;

use App\Constants\AppConstants;
use App\Constants\PropertyConstants;
use App\Constants\StatusConstants;
use App\Services\Shop\CartService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function defaultImage()
    {
        return $this->hasOne(PropertyFile::class, 'property_id')
            ->latest()
            ->where("type", "image")
            ->where("is_default", AppConstants::ONE);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, "category_id");
    }

    public function getDefaultImage(bool $as_file = false)
    {
        $image = $this->defaultImage;
        if (empty($image)) {
            $image = optional($this->files()->first())->file;
        }
        if (empty($image->file)) {
            return "";
        }
        return $as_file ? $image : $image->file->url();
    }

    public function files()
    {
        return $this->hasMany(PropertyFile::class, "property_id")->orderBy("order");
    }

    public function amenities()
    {
        return $this->hasMany(PropertyAmenity::class, "property_id");
    }

    public function videos()
    {
        return $this->hasMany(PropertyFile::class, "property_id")->where("type", PropertyConstants::VIDEO);
    }

    public function images()
    {
        return $this->hasMany(PropertyFile::class, "property_id")->where("type", PropertyConstants::IMAGE);
    }

    public function scopeActive($query, $value = null)
    {
        $query->where("status", StatusConstants::ACTIVE)
            ->orwhere("status", StatusConstants::INACTIVE);
    }

    public function scopeFilterByStatus($query, $value)
    {
        return $query->where("status", $value);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function specifications()
    {
        return $this->hasMany(PropertySpecification::class);
    }

    public function savedProperties()
    {
        return $this->hasMany(SavedProperty::class, "property_id");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getAmount($column)
    {
        return $this->currency->short_name . "" . $this->$column;
    }

    public function isAvailable()
    {
        return strtolower($this->status) == strtolower(PropertyConstants::STATUS_AVAILABLE);
    }

    public function getStatus()
    {
        return ucwords(str_replace("_", " ", $this->status));
    }

    public function getFlagUrl()
    {
        $location = $this->address;

        $url = "";
        if (str_contains($location, 'Kingdom')) {
            $url = "https://maihomm.com/wp-content/uploads/2023/02/united-kingdom.png";
        }
        if (str_contains($location, 'USA')) {
            $url = "https://maihomm.com/wp-content/uploads/2023/02/usa.png";
        }
        if (str_contains($location, 'Portugal')) {
            $url = "https://maihomm.com/wp-content/uploads/2023/02/portugal-1.png";
        }
        if (str_contains($location, 'Spain')) {
            $url = "https://maihomm.com/wp-content/uploads/2023/02/spain.png";
        }
        if (str_contains($location, 'France')) {
            $url = "https://maihomm.com/wp-content/uploads/2023/02/france.png";
        }
        if (str_contains($location, 'London')) {
            $url = "https://maihomm.com/wp-content/uploads/2023/02/united-kingdom.png";
        }
        return $url;
    }

    public function isSavedProperty()
    {
        $saved_property  = $this->hasMany(SavedProperty::class, 'property_id')
            ->where("id", auth()->id())
            ->latest()
            ->first();

        return empty($saved_property) ? false : true;
    }

    public function scopeSearch($query, $value)
    {
        $query->whereRaw("CONCAT(name,' ', uuid ,' ',description) LIKE ?", ["%$value%"]);
    }

    public function inCart()
    {
        $boolean = false;
        $cart = CartService::getCartByUser(auth()->id());
        $check_cart_items = $cart->cartItems->where("property_id", $this->id)->first();
        if (!is_null($check_cart_items)) {
            $boolean = true;
        }
        return $boolean;
    }

    public function inFavorite()
    {
        $boolean = false;
        $user_id = auth()->id();
        $wheres = ["user_id" => $user_id, "property_id" => $this->id];
        $check_favorites = Favorite::where($wheres)->first();
        if (!is_null($check_favorites)) {
            $boolean = true;
        }
        return $boolean;
    }
}
