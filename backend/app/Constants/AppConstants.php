<?php

namespace App\Constants;

class AppConstants
{
    const REGISTER_BONUS = 250000;
    const ZERO = 0;
    const ONE = 1;
    const API = "api";
    const WEB = "web";
    const MAX_PROFILE_PIC_SIZE = 2048;

    const MALE = 'Male';
    const FEMALE = 'Female';
    const OTHERS = 'Others';


    const GENDERS = [
        "male" => self::MALE,
        "female" => self::FEMALE,
        "others" => self::OTHERS,
    ];

    const PILL_CLASSES = [
        TransactionConstants::CREDIT => "success",
        StatusConstants::COMPLETED => "success",
        StatusConstants::PENDING => "primary",
        StatusConstants::PROCESSING => "info",
        StatusConstants::ACTIVE => "success",
        StatusConstants::INACTIVE => "danger",
        StatusConstants::DECLINED => "danger",
        StatusConstants::DELETED => "danger",
        TransactionConstants::DEBIT => "danger",
        StatusConstants::CANCELLED => "danger",
        StatusConstants::CLOSED => "danger",
        StatusConstants::UPCOMING => "warning",
        StatusConstants::ONGOING => "success",
    ];

    const SUDO_EMAIL = "admin@maihomm.com";

    const ADMIN_PAGINATION_SIZE = 100;

    const NIGERIA_ID = 160;
    const LAGOS_STATE_ID = 2671;

    const ID_OPTIONS = [
        "driving-license" => "Driving License",
        "national-id" => "National ID",
        "passport" => "Passport"
    ];

    const NIN = "NIN";

    const PASSWORD_RESET = "password_reset";
    const TWO_FA = "two_factor_auth";
}
