<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\View\JsLayout;

use Exto\CustomerCard\Model\View\JsLayout\ProcessorInterface;
use Magento\Framework\Stdlib\ArrayManager;

/**
 * Tabs js layout processor.
 */
class TabsProcessor implements ProcessorInterface
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    /**
     * {@inheritdoc}
     */
    public function process(array $layout)
    {
        $layout = $this->arrayManager->merge(
            'components/customer-card-modal/children/card',
            $layout,
            [
                'tabs' => $this->getTabs()
            ]
        );

        return $layout;
    }

    /**
     * Get tabs.
     *
     * @return array
     */
    private function getTabs()
    {
        return [
            [
                'code' => 'sales-overview',
                'title' => __('Customer Value')
            ],
            [
                'code' => 'behaviour',
                'title' => __('Behaviour')
            ],
            [
                'code' => 'sales-order-summary',
                'title' => __('Orders Summary')
            ],
            [
                'code' => 'sales-purchase-history',
                'title' => __('Purchase History')
            ],
            [
                'code' => 'communication',
                'title' => __('Communication and Support')
            ],
            [
                'code' => 'merketing',
                'title' => __('Marketing involvement')
            ]
        ];
    }
}
