<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Report;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;

/**
 * Review report.
 */
class ReviewReport
{
    /**
     * @var ReviewCollectionFactory
     */
    private $reviewCollectionFactory;

    /**
     * @param ReviewCollectionFactory $reviewCollectionFactory
     */
    public function __construct(ReviewCollectionFactory $reviewCollectionFactory)
    {
        $this->reviewCollectionFactory = $reviewCollectionFactory;
    }

    /**
     * Get customer review count.
     *
     * @param CustomerInterface $customer
     * @return int
     */
    public function getCustomerReviewCount(CustomerInterface $customer)
    {
        /** @var \Magento\Review\Model\ResourceModel\Review\Collection $collection */
        $collection = $this->reviewCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customer->getId());
        $collection->addExpressionFieldToSelect('count', 'COUNT(*)', []);
        $collection->getSelect()->group('customer_id');

        $row = $collection->getConnection()->fetchAssoc($collection->getSelect());

        return isset($row['count']) ? $row['count'] : 0;
    }
}
