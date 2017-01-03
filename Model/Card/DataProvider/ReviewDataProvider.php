<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Exto\CustomerCard\Model\Report\ReviewReport;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Review data provider.
 */
class ReviewDataProvider implements DataProviderInterface
{
    /**
     * @var ReviewReport
     */
    private $reviewReport;

    /**
     * @param ReviewReport $reviewReport
     */
    public function __construct(ReviewReport $reviewReport)
    {
        $this->reviewReport = $reviewReport;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'review' => [
                'count' => $this->reviewReport->getCustomerReviewCount($customer)
            ]
        ];
    }
}
