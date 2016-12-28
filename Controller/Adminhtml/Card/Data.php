<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Controller\Adminhtml\Card;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Data.
 */
class Data extends Action
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var DataProviderInterface
     */
    private $dataProvider;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        DataProviderInterface $dataProvider
    ) {
        parent::__construct($context);
        $this->customerRepository = $customerRepository;
        $this->dataProvider = $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $customerId = $this->getRequest()->getParam('customer_id');
            $customer = $this->customerRepository->getById($customerId);
            $data = [
                'data' => $this->dataProvider->getData($customer)
            ];
        } catch (NoSuchEntityException $e) {
            $data = [
                'error' => true,
                'errorMessage' => $e->getMessage()
            ];
        }

        return $result->setData($data);
    }
}
