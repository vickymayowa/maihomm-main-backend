<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySpecification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getIcon()
    {
        $metadata = json_decode($this->metadata);

        $icon = "";
        if ($metadata->icon == "icon-price") {
            $icon = "Price";
        }
        if ($metadata->icon == "icon-bedroom") {
            $icon = "Bedroom";
        }
        if ($metadata->icon == "icon-sofa") {
            $icon = "Bathroom";
        }
        if ($metadata->icon == "icon-status") {
            $icon = "Status";
        }
        if ($metadata->icon == "fa check") {
            $icon = "Check";
        }
        if ($metadata->icon == "fas fa-rocket") {
            $icon = "Closing date";
        }
        if ($metadata->icon == "fas fa-hand-holding-usd") {
            $icon = "Holding money";
        }
        if ($metadata->icon == "fas fa-users") {
            $icon = "Users";
        }
        if ($metadata->icon == "fas fa-money-bill-wave") {
            $icon = "Money bill";
        }
        if ($metadata->icon == null) {
            $icon = null;
        }

        return $icon;
    }
}
