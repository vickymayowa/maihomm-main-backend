<?php

namespace App\Constants;

class TransactionConstants
{

    const DEBIT = "Debit";
    const CREDIT = "Credit";

    const WALLET_TRANSFER_PERCENT_FEE = 1;
    const WALLET_WITHDRAWAL_WITH_BANK_PERCENT_FEE = 2;
    const WALLET_WITHDRAWAL_WITH_BANK_MINIMUM_AMOUNT = 3000;

    const FIXED_VALUE = "Fixed";
    const PERCENTAGE_VALUE = "Percentage";

    const MANUAL_PAYMENT_BANKS = [
        [
            "account_name" => "Account name",
            "account_number" => "123455",
            "bank_name" => "Bank Name"
        ]
    ];

    const MANUAL_DEPOSIT_FIXED_FEE = 100;

}
