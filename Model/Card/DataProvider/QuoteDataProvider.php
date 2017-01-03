<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Quote data provider.
 */
class QuoteDataProvider implements DataProviderInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param CartRepositoryInterface $cartRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->cartRepository = $cartRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        $data = [];

        $activeCart = $this->getActiveCart($customer);
        if ($activeCart instanceof CartInterface) {
            $data['quote']['active'] = [
                'items_count' => $activeCart->getItemsCount(),
                'total' => $activeCart->getBaseSubtotal()
            ];
        }
        return $data;
    }

    /**
     * Get active customer cart.
     *
     * @param CustomerInterface $customer
     * @return CartInterface|null
     */
    private function getActiveCart(CustomerInterface $customer)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            'customer_id',
            $customer->getId()
        )->create();
        $carts = $this->cartRepository->getList($searchCriteria)->getItems();

        $activeCart = null;

        foreach ($carts as $cart) {
            if ($cart->getIsActive()) {
                $activeCart = $cart;
            }
        }

        return $activeCart;
    }
}
