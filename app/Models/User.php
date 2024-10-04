<?php

namespace App\Models;

use App\Constants\AppConstants;
use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $fillable = [
    //     'name', 'email', 'password', 'google_id',
    // ];

    public function avatarUrl()
    {
        return asset("user.png");
    }

    public function names()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getFullNameAttribute()
    {
        return $this->names();
    }

    public function avatar()
    {
        return $this->belongsTo(File::class, "avatar_id");
    }
    public function country()
    {
        return $this->belongsTo(Country::class, "country_id");
    }

    public function state()
    {
        return $this->belongsTo(State::class, "state_id");
    }
    public function city()
    {
        return $this->belongsTo(City::class, "state_id");
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, "user_id");
    }

    public function completedPayments(){
        return $this->payments()->where('status', 'Completed')->sum('amount');
    }

    public function imageUrl($format = "url")
    {
        $image = $this->avatar;
        if (!empty($image)) {
            return $image->url();
        } else {
            return $this->avatarUrl();
        }
    }
    public function scopeSearch($query, $value)
    {
        $query->whereRaw("CONCAT(first_name,' ', email , ' ', ' ' ,ref_code) LIKE ?", ["%$value%"]);
    }
    public function isAdmin()
    {
        if ($this->role == "Admin") {
            return true;
        } else {
            return false;
        }
    }

    public function isVerified()
    {
        $verifications = $this->verifications;
        $document_verifications = $verifications
            ->whereIn("id_type", array_keys(AppConstants::ID_OPTIONS))
            ->where("status", StatusConstants::VERIFIED)
            ->count();

        // $nin_verification = $verifications->where("id_type", AppConstants::NIN)
        //     ->where("status", StatusConstants::VERIFIED)
        //     ->count();

        // if ($document_verifications > 0 && $nin_verification > 0) {
        //     $is_verified = true;
        // }


        if ($document_verifications > 0) {
            $is_verified = true;
        }

        return $is_verified ?? false;
    }

    public function verificationData()
    {
        $verifications = $this->verifications;
        $document_verifications = $verifications
            ->whereIn("id_type", array_keys(AppConstants::ID_OPTIONS))
            ->where("status", StatusConstants::VERIFIED)
            ->count();

        $nin_verification = $verifications->where("id_type", AppConstants::NIN)
            ->where("status", StatusConstants::VERIFIED)
            ->count();

        // if ($document_verifications > 0 && $nin_verification > 0) {
        if ($document_verifications) {
            $is_verified = true;
        }

        return [
            "id_card" => $document_verifications > 0,
            // "nin_verification" => $nin_verification > 0,
            "is_verified" => $is_verified ?? false
        ];
    }

    public function portfolio()
    {
        return $this->hasOne(Portfolio::class, "user_id");
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class, "user_id");
    }
    public function verifications()
    {
        return $this->hasMany(KycVerification::class, "user_id")->latest();
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function isRead($id)
    {
        $user = auth()->user();
        $userReadNotification = $user
            ->readNotifications
            ->whereNotNull("read_at")
            ->find($id);
        if (!is_null($userReadNotification)) {
            return true;
        }else{
            return false;
        }
    }
}
