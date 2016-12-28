<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Card\View\JsLayout;

use Exto\CustomerCard\Model\View\JsLayout\ProcessorInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Stdlib\ArrayManager;

/**
 * Core js layout processor.
 */
class CoreProcessor implements ProcessorInterface
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @param ArrayManager $arrayManager
     * @param UrlInterface $url
     */
    public function __construct(
        ArrayManager $arrayManager,
        UrlInterface $url
    ) {
        $this->arrayManager = $arrayManager;
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function process(array $layout)
    {
        $layout = $this->arrayManager->merge(
            'components/customer-card.data.provider',
            $layout,
            [
                'update_url' => $this->url->getUrl('customer_card/card/data')
            ]
        );

        return $layout;
    }
}
