<?php

namespace Academia\Subscription\Application\Services\Subscription\CancelSubscription;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Core\Helpers\DateTime;
use Academia\Subscription\Domain\Repositories\SubscriptionRepository;

class CancelSubscription
{
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(
        SubscriptionRepository $subscriptionRepository
    )
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function execute(CancelSubscriptionRequestDto $cancelSubscriptionRequestDto): CancelSubscriptionResponseDto
    {
        $subscription = $this->subscriptionRepository->getById($cancelSubscriptionRequestDto->getId());
        if (empty($subscription)) {
            throw new NotFoundException("Inscrição não foi encontrada para efetuar o cancelamento.");
        }
        $canceling_date = DateTime::createDateTimeObjFromDateString($cancelSubscriptionRequestDto->getCencelingDate());
        $subscription->cancel($canceling_date, $cancelSubscriptionRequestDto->getCancelingReason());
        $this->subscriptionRepository->save($subscription);
        return new CancelSubscriptionResponseDto(
            $subscription->getId(),
            $subscription->getCancelDate(),
            $subscription->getCancelReason()
        );
    }
}