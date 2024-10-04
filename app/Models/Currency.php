<?php

namespace App\Models;

use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;
    public $table = "currencies";

    protected $guarded = [];

    public function logoUrl()
    {
        $logo = $this->logo;
        if(empty($logo)){
            $logo = "logo";
        }
        $url = readFileUrl("encrypt" , $logo);
        return $url;
    }

    public function scopeActive($query)
    {
        $query->where("status" , StatusConstants::ACTIVE);
    }
}
