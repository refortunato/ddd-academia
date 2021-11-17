<?php 

namespace Academia\Subscription\Application\Services\Subscription\PaySubscription;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Core\Helpers\DateTime;
use Academia\Subscription\Domain\Entities\Subscription;
use Academia\Subscription\Domain\Repositories\SubscriptionRepository;

class PaySubscription
{
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(
        SubscriptionRepository $subscriptionRepository
    )
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function execute(PaySubscriptionRequestDto $paySubscriptionRequestDto): ?Subscription
    {
        $subscritiption = $this->subscriptionRepository->getById($paySubscriptionRequestDto->getSubscriptionId());
        if (empty($subscritiption)) {
            throw new NotFoundException("Inscrição não foi encontrada para realizar a baixa");
        }
        $payment_date_obj = DateTime::createDateTimeObjFromDateString($paySubscriptionRequestDto->getPaymentDate());
        $subscritiption->pay($payment_date_obj);
        return $this->subscriptionRepository->save($subscritiption);
    }
}