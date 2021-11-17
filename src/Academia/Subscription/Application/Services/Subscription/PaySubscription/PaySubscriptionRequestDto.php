<?php 

namespace Academia\Subscription\Application\Services\Subscription\PaySubscription;

class PaySubscriptionRequestDto
{
    private string $subscription_id;
    private string $payment_date;

    public function __construct(
        string $subscription_id,
        string $payment_date
    )
    {
        $this->subscription_id = $subscription_id;
        $this->payment_date = $payment_date;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscription_id;
    }

    public function getPaymentDate(): string
    {
        return $this->payment_date;
    }
}