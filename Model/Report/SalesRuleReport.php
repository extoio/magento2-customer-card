<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Report;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

/**
 * Sales rule report.
 */
class SalesRuleReport
{
    /**
     * @var OrderCollectionFactory
     */
    private $collectionFactory;

    /**
     * @param OrderCollectionFactory $collectionFactory
     */
    public function __construct(OrderCollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get coupon used count.
     *
     * @param CustomerInterface $customer
     * @return int
     */
    public function getCouponUsedCount(CustomerInterface $customer)
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter(OrderInterface::CUSTOMER_ID, $customer->getId());
        $collection->addAttributeToFilter(OrderInterface::COUPON_CODE, ['notnull' => true]);
        $collection->getSelect()->group(OrderInterface::COUPON_CODE);

        $row = $collection->getConnection()->fetchAll($collection->getSelect());

        return count($row);
    }

    /**
     * Get promo orders count.
     *
     * @param CustomerInterface $customer
     * @return int
     */
    public function getPromoOrdersCount(CustomerInterface $customer)
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter(OrderInterface::CUSTOMER_ID, $customer->getId());
        $collection->addAttributeToFilter(OrderInterface::APPLIED_RULE_IDS, ['notnull' => true]);

        $row = $collection->getConnection()->fetchAll($collection->getSelect());

        return count($row);
    }
}
