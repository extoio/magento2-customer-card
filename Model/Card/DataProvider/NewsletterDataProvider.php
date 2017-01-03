<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Newsletter\Model\ResourceModel\Subscriber\CollectionFactory as SubscriberCollectionFactory;

/**
 * Newsletter data provider.
 */
class NewsletterDataProvider implements DataProviderInterface
{
    /**
     * @var SubscriberCollectionFactory
     */
    private $subscriberCollectionFactory;

    /**
     * @param SubscriberCollectionFactory $subscriberCollectionFactory
     */
    public function __construct(
        SubscriberCollectionFactory $subscriberCollectionFactory
    ) {
        $this->subscriberCollectionFactory = $subscriberCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'newsletter' => [
                'is_subscribed' => $this->isCustomerSubscribed($customer)
            ]
        ];
    }

    /**
     * Is customer subscribed.
     *
     * @param CustomerInterface $customer
     * @return bool
     */
    private function isCustomerSubscribed(CustomerInterface $customer)
    {
        /** @var \Magento\Newsletter\Model\ResourceModel\Subscriber\Collection $collection */
        $collection = $this->subscriberCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customer->getId());
        /** @var \Magento\Newsletter\Model\Subscriber $subscriber */
        $subscriber = $collection->getFirstItem();

        return $subscriber->isSubscribed();
    }
}
