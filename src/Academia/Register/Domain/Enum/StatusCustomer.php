<?php

namespace Academia\Register\Domain\Enum;

use Academia\Core\Enum;

class StatusCustomer extends Enum
{
    const ACTIVE = 'Active';
    const BLOCKED = 'Blocked';
    const INACTIVE = 'Inactive';
}
