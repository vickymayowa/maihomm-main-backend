<?php

namespace App\Constants;

class PaymentConstants
{
    const GATEWAY_WALLET = "Wallet";

    const PAYMENT_OPTIONS = [
        self::GATEWAY_WALLET => self::GATEWAY_WALLET,
    ];

    const ACTIVITY_PROPERTY_PURCHASE = "PROPERTY_PURCHASE";

}
