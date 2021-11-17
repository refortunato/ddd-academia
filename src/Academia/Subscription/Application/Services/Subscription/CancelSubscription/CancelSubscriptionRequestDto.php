<?php

namespace Academia\Subscription\Application\Services\Subscription\CancelSubscription;

class CancelSubscriptionRequestDto
{
    private string $id;
    private string $cenceling_date;
    private string $canceling_reason;

    public function __construct(
        string $id,
        string $cenceling_date,
        string $canceling_reason
    )
    {
        $this->id = $id;
        $this->cenceling_date = $cenceling_date;
        $this->canceling_reason = trim($canceling_reason);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCencelingDate(): string
    {
        return $this->cenceling_date;
    }

    public function getCancelingReason(): string
    {
        return $this->canceling_reason;
    }

}