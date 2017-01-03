<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Block\Adminhtml\Customer;

use Exto\CustomerCard\Model\View\JsLayout\ProcessorInterface;
use Exto\CustomerCard\Model\View\JsLayoutInterface;
use Exto\CustomerCard\Model\View\JsLayoutInterfaceFactory;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

/**
 * Class Card.
 */
class Card extends Template
{
    /**
     * @var JsLayoutInterfaceFactory
     */
    private $jsLayoutFactory;

    /**
     * @var ProcessorInterface[]
     */
    private $jsLayoutProcessors;

    /**
     * @param Context $context
     * @param JsLayoutInterfaceFactory $jsLayoutFactory
     * @param array $data
     * @param ProcessorInterface[] $jsLayoutProcessors
     */
    public function __construct(
        Context $context,
        JsLayoutInterfaceFactory $jsLayoutFactory,
        array $data = [],
        array $jsLayoutProcessors = []
    ) {
        parent::__construct($context, $data);
        $this->jsLayoutFactory = $jsLayoutFactory;
        $this->jsLayoutProcessors = $jsLayoutProcessors;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessedJsLayout()
    {
        /** @var JsLayoutInterface $jsLayout */
        $jsLayout = $this->jsLayoutFactory->create([
            'layout' => $this->jsLayout,
            'processors' => $this->jsLayoutProcessors
        ]);

        return \Zend_Json::encode($jsLayout->getLayout());
    }
}
