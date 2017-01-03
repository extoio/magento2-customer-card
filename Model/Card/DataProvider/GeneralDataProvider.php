<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Customer\Api\CustomerNameGenerationInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * General customer info data provider.
 */
class GeneralDataProvider implements DataProviderInterface
{
    /**
     * @var CustomerNameGenerationInterface
     */
    private $customerNameGeneration;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param CustomerNameGenerationInterface $customerNameGeneration
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        CustomerNameGenerationInterface $customerNameGeneration,
        UrlInterface $urlBuilder
    ) {
        $this->customerNameGeneration = $customerNameGeneration;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'customer' => [
                'name' => $this->customerNameGeneration->getCustomerName($customer),
                'email' => $customer->getEmail(),
                'url' => $this->urlBuilder->getUrl(
                    'customer/index/edit',
                    ['id' => $customer->getId()]
                )
            ]
        ];
    }
}
