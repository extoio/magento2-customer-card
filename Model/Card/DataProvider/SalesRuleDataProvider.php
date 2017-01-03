<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Exto\CustomerCard\Model\Report\SalesRuleReport;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Sales rule data provider.
 */
class SalesRuleDataProvider implements DataProviderInterface
{
    /**
     * @var SalesRuleReport
     */
    private $salesRuleReport;

    /**
     * @param SalesRuleReport $salesRuleReport
     */
    public function __construct(SalesRuleReport $salesRuleReport)
    {
        $this->salesRuleReport = $salesRuleReport;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'sales_rule' => [
                'used_coupon_count' => $this->salesRuleReport->getCouponUsedCount($customer),
                'promo_orders_count' => $this->salesRuleReport->getPromoOrdersCount($customer)
            ]
        ];
    }
}
