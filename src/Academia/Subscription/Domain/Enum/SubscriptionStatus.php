<?php

namespace Academia\Subscription\Domain\Enum;

use Academia\Core\Enum;

class SubscriptionStatus extends Enum
{
    const OPENED = 'Opened';
    const PAID = 'Paid';
    const EXPIRED = 'Expired';
    const CANCELED = 'Canceled';
}
