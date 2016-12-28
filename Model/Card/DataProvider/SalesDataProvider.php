<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Sales data provider.
 */
class SalesDataProvider implements DataProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'sales' => [
                'monthly' => 1,
                'yearly' => 1,
                'all' => 11
            ]
        ];
    }
}
