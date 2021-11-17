<?php

namespace Academia\Subscription\Application\Services\Subscription\CreateSubscription;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Core\Helpers\DateTime;
use Academia\Core\Validators\DateTimeValidator;
use Academia\Subscription\Domain\Entities\Subscription;
use Academia\Subscription\Domain\Entities\SubscriptionService;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Domain\Repositories\SubscriptionRepository;

class CreateSubscription
{
    private SubscriptionRepository $subscriptionRepository;
    private SubscriptionPlanRepository $subscriptionPlanRepository;
    private ServiceRepository $serviceRepository;

    public function __construct(
        SubscriptionRepository $subscriptionRepository,
        SubscriptionPlanRepository $subscriptionPlanRepository,
        ServiceRepository $serviceRepository
    )
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionPlanRepository = $subscriptionPlanRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function execute(CreateSubscriptionRequestDto $createSubscriptionRequestDto): CreateSubscriptionResponseDto
    {
        $subscriptionPlan = $this->subscriptionPlanRepository->getById($createSubscriptionRequestDto->getSubscriptionPlanId());
        if (empty($subscriptionPlan)) {
            throw new NotFoundException("Plano de inscrição não foi encontrado para efetuar a inscrição.");
        }
        DateTimeValidator::dateTimeIsValidOrException('Data de início', $createSubscriptionRequestDto->getStartDate());
        $start_date = DateTime::createDateTimeObjFromDateString($createSubscriptionRequestDto->getStartDate());
        $subscription = new Subscription(
            '',
            $createSubscriptionRequestDto->getCustomerId(),
            $createSubscriptionRequestDto->getCustomerName(),
            $createSubscriptionRequestDto->getCustomerCpf(),
            $subscriptionPlan,
            $start_date
        );
        if (empty($createSubscriptionRequestDto->getServicesId())) {
            throw new \DomainException("Ao menos 1 serviço deve ser informado para criar a inscrição");
        }
        foreach($createSubscriptionRequestDto->getServicesId() as $service_id) {
            $service = $this->serviceRepository->getById($service_id);
            if (empty($service)) {
                throw new NotFoundException("Plano de inscrição não foi encontrado para efetuar a inscrição.");
            }
            $subscriptionService = new SubscriptionService(
                '',
                $subscription->getId(),
                $service->getId(),
                $service->getName(),
                $service->getPrice()
            );
            $subscription->addSubscriptionService($subscriptionService);
        }
        $this->subscriptionRepository->save($subscription);
        return new CreateSubscriptionResponseDto($subscription);
    }
}