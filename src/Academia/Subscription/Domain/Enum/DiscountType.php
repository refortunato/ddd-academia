<?php

namespace Academia\Subscription\Domain\Enum;

use Academia\Core\Enum;

class DiscountType extends Enum
{
    const PERCENT = 'Percent';
    const VALUE = 'Value';
}
