<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Report;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

/**
 * Sales report.
 */
class SalesReport
{
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @var OrderCollectionFactory
     */
    private $collectionFactory;

    /**
     * @param TimezoneInterface $timezone
     * @param OrderCollectionFactory $collectionFactory
     */
    public function __construct(
        TimezoneInterface $timezone,
        OrderCollectionFactory $collectionFactory
    ) {
        $this->timezone = $timezone;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get monthly total.
     *
     * @param CustomerInterface $customer
     * @return array
     */
    public function getMonthlyTotalData(CustomerInterface $customer)
    {
        $collection = $this->buildReportCollection($customer);

        $from = $this->timezone->date()
            ->modify('-30 day');
        $collection->addFieldToFilter(OrderInterface::CREATED_AT, [
            'gt' => $from
        ]);

        return $this->getReportTotalData($collection);
    }

    /**
     * Get yearly total.
     *
     * @param CustomerInterface $customer
     * @return array
     */
    public function getYearlyTotalData(CustomerInterface $customer)
    {
        $collection = $this->buildReportCollection($customer);

        $from = $this->timezone->date()
            ->modify('-365 day');
        $collection->addFieldToFilter(OrderInterface::CREATED_AT, [
            'gt' => $from
        ]);

        return $this->getReportTotalData($collection);
    }

    /**
     * Get lifetime total.
     *
     * @param CustomerInterface $customer
     * @return array
     */
    public function getLifetimeTotalData(CustomerInterface $customer)
    {
        $collection = $this->buildReportCollection($customer);

        return $this->getReportTotalData($collection);
    }

    /**
     * Build report collection.
     *
     * @param CustomerInterface $customer
     * @return AbstractCollection
     */
    private function buildReportCollection(CustomerInterface $customer)
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter(OrderInterface::CUSTOMER_ID, $customer->getId());
        $collection->getSelect()->group(OrderInterface::CUSTOMER_ID);

        return $collection;
    }

    /**
     * Get report total.
     *
     * @param AbstractCollection $collection
     * @return array
     */
    private function getReportTotalData(AbstractCollection $collection)
    {
        $collection->addExpressionFieldToSelect('orders_total', 'SUM({{base_grand_total}})', 'base_grand_total');
        $collection->addExpressionFieldToSelect('orders_count', 'COUNT(*)', []);

        $row = $collection->getConnection()->fetchRow($collection->getSelect());

        return [
            'total' => isset($row['orders_total']) ? $row['orders_total'] : 0,
            'count' => isset($row['orders_count']) ? $row['orders_count'] : 0
        ];
    }
}
