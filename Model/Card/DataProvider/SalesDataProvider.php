<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\DataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Exto\CustomerCard\Model\Formatter\DateTimeFormatter;
use Exto\CustomerCard\Model\Report\SalesReport;
use Magento\Backend\Model\UrlInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Sales data provider.
 */
class SalesDataProvider implements DataProviderInterface
{
    /**
     * @var \Exto\CustomerCard\Model\Report\SalesReport
     */
    private $salesReport;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    private $urlBuilder;

    /**
     * @var \Exto\CustomerCard\Model\Formatter\DateTimeFormatter
     */
    private $dateTimeFormatter;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @param SalesReport $salesReport
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param UrlInterface $urlBuilder
     * @param DateTimeFormatter $dateTimeFormatter
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        SalesReport $salesReport,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        UrlInterface $urlBuilder,
        DateTimeFormatter $dateTimeFormatter,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->salesReport = $salesReport;
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->urlBuilder = $urlBuilder;
        $this->dateTimeFormatter = $dateTimeFormatter;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'sales' => [
                'total' => [
                    'monthly' => $this->formatPriceData(
                        $this->salesReport->getMonthlyTotalData($customer),
                        ['total']
                    ),
                    'yearly' => $this->formatPriceData(
                        $this->salesReport->getYearlyTotalData($customer),
                        ['total']
                    ),
                    'all' => $this->formatPriceData(
                        $this->salesReport->getLifetimeTotalData($customer),
                        ['total']
                    )
                ],
                'orders' => $this->getOrdersData($customer)
            ]
        ];
    }

    /**
     * Get customer data.
     *
     * @param CustomerInterface $customer
     * @return array
     */
    private function getOrdersData(CustomerInterface $customer)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            OrderInterface::CUSTOMER_ID,
            $customer->getId()
        )->create();
        $orders = $this->orderRepository->getList($searchCriteria)->getItems();
        $ordersData = [];
        foreach ($orders as $order) {
            /** @var $order \Magento\Sales\Model\Order */
            $ordersData[] = [
                'increment_id' => $order->getIncrementId(),
                'created_at' => $this->dateTimeFormatter->formatMedium($order->getCreatedAt()),
                'status' => $order->getStatus(),
                'total' => $order->formatPriceTxt($order->getGrandTotal()),
                'url' => $this->urlBuilder->getUrl('sales/order/view', ['order_id' => $order->getEntityId()])
            ];
        }

        return $ordersData;
    }

    /**
     * Format price data.
     *
     * @param array $data
     * @param array $columns
     * @return array
     */
    private function formatPriceData(array $data, array $columns)
    {
        foreach ($columns as $column) {
            if (isset($data[$column])) {
                $data[$column] = $this->priceCurrency->format(
                    $data[$column],
                    false
                );
            }
        }

        return $data;
    }
}
