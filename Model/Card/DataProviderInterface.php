<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Data provider interface.
 *
 * @api
 */
interface DataProviderInterface
{
    /**
     * Get data.
     *
     * @param CustomerInterface $customer
     * @return array
     */
    public function getData(CustomerInterface $customer);
}
