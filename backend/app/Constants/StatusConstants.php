<?php

namespace App\Constants;

class StatusConstants
{
    const ACTIVE = "Active";
    const INACTIVE = "Inactive";
    const CREATED = "Created";
    const STARTED = "Started";
    const APPROVED = "Approved";
    const SUSPENDED = "Suspended";
    const PENDING = "Pending";
    const COMPLETED = "Completed";
    const PROCESSING = "Processing";
    const CANCELLED = "Cancelled";
    const DECLINED = "Declined";
    const ENDED = "Ended";
    const DELETED = "Deleted";
    const CLOSED = "Closed";
    const ONGOING = "Ongoing";
    const UPCOMING = "Upcoming";
    const PUBLISHED = "Published";
    const VERIFIED = "Verified";
    const REJECTED = "Rejected";
    const AVAILABLE = "Available";
    const SOLD = "Sold";

    const ACTIVE_OPTIONS = [
        self::ACTIVE => "Active",
        self::INACTIVE => "Inactive",
        self::PENDING => "Pending",
    ];

    const PUBLISH_OPTIONS = [
        self::ACTIVE => "Active",
        self::INACTIVE => "Inactive",
    ];


    const PAYMENT_OPTIONS = [
        self::PENDING => "Pending",
        self::PROCESSING => "Processing",
        self::COMPLETED => "Completed",
    ];

    const TRANSACTION_OPTIONS = [
        self::PENDING => "Pending",
        self::COMPLETED => "Completed",
        self::DECLINED => "Declined",
    ];

    const BOOL_OPTIONS = [
        1 => "Yes",
        0 => "No",
    ];
}

