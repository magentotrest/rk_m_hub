<?php

namespace Ueg\Crm\Controller\Adminhtml\amazon;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPagee;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ueg_Crm::crm');
        $resultPage->addBreadcrumb(__('Amazon Sales Log'), __('Amazon Sales Log'));
        $resultPage->addBreadcrumb(__('Manage item'), __('Amazon Sales Log'));
        $resultPage->getConfig()->getTitle()->prepend(__('Amazon Sales Log'));

        return $resultPage;
    }
}
?>