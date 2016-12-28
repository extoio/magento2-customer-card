<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Block\Adminhtml\Order\View\Info;

use Exto\CustomerCard\Model\View\JsLayoutInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Block\Adminhtml\Order\AbstractOrder;
use Magento\Sales\Helper\Admin;

/**
 * Class Card.
 */
class Card extends AbstractOrder
{
    /**
     * @var JsLayoutInterface
     */
    private $jsLayoutData;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param Admin $adminHelper
     * @param JsLayoutInterface $jsLayout
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Admin $adminHelper,
        JsLayoutInterface $jsLayout,
        array $data = []
    ) {
        parent::__construct($context, $registry, $adminHelper, $data);
        $this->jsLayoutData = $jsLayout;
    }

    /**
     * Get customer id.
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getOrder()->getCustomerId();
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayoutData()
    {
        return \Zend_Json::encode($this->jsLayoutData->getLayout());
    }
}
