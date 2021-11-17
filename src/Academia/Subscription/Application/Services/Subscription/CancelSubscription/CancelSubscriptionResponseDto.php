<?php

namespace Academia\Subscription\Application\Services\Subscription\CancelSubscription;

class CancelSubscriptionResponseDto
{
    private string $subsription_id;
    private \DateTime $canceling_date;
    private string $canceling_reason;

    public function __construct(
        string $subsription_id,
        \DateTime $canceling_date,
        string $canceling_reason
    )
    {
        $this->subsription_id = $subsription_id;
        $this->canceling_date = $canceling_date;
        $this->canceling_reason = $canceling_reason;
    }

    public function getSubsriptionId(): string
    {
        return $this->subsription_id;
    }

    public function getCancelingDate(): \DateTime
    {
        return $this->canceling_date;
    }

    public function getCancelingReason(): string
    {
        return $this->canceling_reason;
    }

    public function mapToArray(): array
    {
        return [
            'subsription_id' => $this->getSubsriptionId(),
            'canceling_date' => $this->getCancelingDate()->format('Y-m-d'),
            'canceling_reason' => $this->getCancelingReason(),
        ];
    }

}