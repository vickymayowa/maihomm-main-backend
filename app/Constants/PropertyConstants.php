<?php

namespace App\Constants;

class PropertyConstants
{
    const NONE = "noner";
    const ALPHABETIC_ORDER = "alphabetic-order";
    const PRICE_LOW_TO_HIGH = "price-low-to-high";
    const PRICE_HIGH_TO_LOW = "price-high-to-low";
    const DATE_OLD_TO_NEW = "date-old-to-new";
    const DATE_NEW_TO_OLD = "date-new-to-old";

    const IMAGE = "image";
    const VIDEO = "video";

    const FILTER_OPTIONS = [
        self::NONE => "None",
        self::ALPHABETIC_ORDER => "Alphabet",
        self::PRICE_LOW_TO_HIGH => "Price - Low to High",
        self::PRICE_HIGH_TO_LOW => "Price - High to Low",
        self::DATE_OLD_TO_NEW => "Date - Old to New",
        self::DATE_NEW_TO_OLD => "Date - New to Old"
    ];

    const ICON_OPTIONS = [
        "price" => "icon-price",
        "bedroom" => "icon-bedroom",
        "bathroom" => "icon-sofa",
        "status" => "icon-status",
        "check" => "fa fa-check",
        "closing-date" => "fas fa-rocket",
        "hand-holding-usd" => "fas fa-hand-holding-usd",
        "users" => "fas fa-users",
        "money-bill" => "fas fa-money-bill-wave",
    ];

    const FEATURES = "Features";
    const AMENITIES = "Amenities";
    const TIMELINES = "Timelines";

    const SPEC_GROUPS = [
        self::FEATURES => self::FEATURES,
        self::AMENITIES => self::AMENITIES,
        self::TIMELINES => "Funding Timelines",
    ];

    const STATUS_SOLD = "Sold";
    const STATUS_AVAILABLE = "Available";
    const STATUS_COMING_SOON = "Coming Soon";
    const STATUS_ALL = "All";

    const STATUS_OPTIONS = [
        self::STATUS_AVAILABLE => "Available",
        self::STATUS_SOLD => "Sold",
        self::STATUS_COMING_SOON => "Coming Soon",
        self::STATUS_ALL => "All"
    ];
}
