<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Exto\CustomerCard\Model\Formatter\DateTimeFormatter;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Wishlist\Model\Item;
use Magento\Wishlist\Model\WishlistFactory;

/**
 * Wishlist data provider.
 */
class WishlistDataProvider implements DataProviderInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var WishlistFactory
     */
    private $wishlistFactory;

    /**
     * @var DateTimeFormatter
     */
    private $dateTimeFormatter;

    /**
     * @param StoreManagerInterface $storeManager
     * @param WishlistFactory $wishlistFactory
     * @param DateTimeFormatter $dateTimeFormatter
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        WishlistFactory $wishlistFactory,
        DateTimeFormatter $dateTimeFormatter
    ) {
        $this->storeManager = $storeManager;
        $this->wishlistFactory = $wishlistFactory;
        $this->dateTimeFormatter = $dateTimeFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'wishlist' => [
                'items' => $this->getWishlistItems($customer)
            ]
        ];
    }

    /**
     * Get wishlist items.
     *
     * @param CustomerInterface $customer
     * @return array
     */
    private function getWishlistItems(CustomerInterface $customer)
    {
        $website = $this->storeManager->getWebsite($customer->getWebsiteId());
        $wishlist = $this->wishlistFactory->create()
            ->setSharedStoreIds($website->getStoreIds())
            ->loadByCustomerId($customer->getId());

        $itemsData = [];
        foreach ($wishlist->getItemCollection() as $item) {
            $itemsData[] = $this->getWishlistItemData($item);
        }

        return $itemsData;
    }

    /**
     * Get wishlist item data.
     *
     * @param Item $item
     * @return array
     */
    private function getWishlistItemData(Item $item)
    {
        return [
            'product' => [
                'name' => $item->getProduct()->getName(),
                'url' => $item->getProductUrl()
            ],
            'qty' => $item->getQty(),
            'added_at' => $this->dateTimeFormatter->formatMedium($item->getAddedAt())
        ];
    }
}
