<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
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
     * @param CustomerLogger $logger
     */
    public function __construct(CustomerLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'behaviour' => [
                'last_visit_at' => $this->logger->get($customer->getId())->getLastVisitAt(),
                'reviews_count' => 1,
                'abandoned_cart' => [
                    'total' => '1111',
                    'items_count' => 11
                ]
            ]
        ];
    }
}
