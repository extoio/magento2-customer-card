<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Exto\CustomerCard\Model\Formatter\DateTimeFormatter;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Logger as CustomerLogger;

/**
 * Behaviour data provider.
 */
class BehaviourDataProvider implements DataProviderInterface
{
    /**
     * @var CustomerLogger
     */
    private $logger;

    /**
     * @var DateTimeFormatter
     */
    private $dateTimeFormatter;

    /**
     * @param CustomerLogger $logger
     * @param DateTimeFormatter $dateTimeFormatter
     */
    public function __construct(
        CustomerLogger $logger,
        DateTimeFormatter $dateTimeFormatter
    ) {
        $this->logger = $logger;
        $this->dateTimeFormatter = $dateTimeFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'behaviour' => [
                'last_visit_at' => $this->getLastVisitAt($customer)
            ]
        ];
    }

    /**
     * Get last visit at.
     *
     * @param CustomerInterface $customer
     * @return string
     */
    private function getLastVisitAt(CustomerInterface $customer)
    {
        $date = $this->logger->get($customer->getId())->getLastVisitAt();

        return $this->dateTimeFormatter->formatMedium($date);
    }
}
