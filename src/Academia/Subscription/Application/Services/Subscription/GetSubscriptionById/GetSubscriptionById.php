<?php

namespace Academia\Subscription\Application\Services\Subscription\GetSubscriptionById;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Subscription\Domain\Entities\Subscription;
use Academia\Subscription\Domain\Repositories\SubscriptionRepository;

class GetSubscriptionById
{
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(
        SubscriptionRepository $subscriptionRepository
    )
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function execute(string $id): Subscription
    {
        $subscription = $this->subscriptionRepository->getById($id);
        if (empty($subscription)) {
            throw new NotFoundException("Inscrição não foi encontrada.");
        }
        return $subscription;
    }
}