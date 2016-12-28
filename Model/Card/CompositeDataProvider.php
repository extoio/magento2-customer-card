<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Composite data provider.
 */
class CompositeDataProvider implements DataProviderInterface
{
    /**
     * @var DataProviderInterface[]
     */
    private $providers;

    /**
     * @param DataProviderInterface[] $providers
     */
    public function __construct(array $providers = [])
    {
        $this->providers = $providers;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        $data = [];

        foreach ($this->getProviders() as $provider) {
            $data = array_merge(
                $data,
                $provider->getData($customer)
            );
        }

        return $data;
    }

    /**
     * Get providers.
     *
     * @return DataProviderInterface[]
     */
    public function getProviders()
    {
        $providers = [];

        foreach ($this->providers as $provider) {
            if ($provider instanceof DataProviderInterface) {
                $providers[] = $provider;
            }
        }

        return $providers;
    }
}
