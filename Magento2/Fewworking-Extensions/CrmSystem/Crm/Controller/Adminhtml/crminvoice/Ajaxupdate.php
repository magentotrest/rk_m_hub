<?php

namespace Ueg\Crm\Controller\Adminhtml\crminvoice;

use Magento\Backend\App\Action\Context;

class Ajaxupdate extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPagee;

    protected $_crmInvoice;

    protected $_customerObject;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        \Ueg\Crm\Model\CrminvoiceFactory $crmInvoice,
        \Magento\Customer\Model\CustomerFactory $customerObject
    ) {
        $this->_crmInvoice = $crmInvoice;
        $this->_customerObject = $customerObject;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $formVar = $params['form_var'];
        parse_str( $formVar, $formParams );
        if(isset($formParams)) {
            //echo "<pre>"; print_r($formParams); echo "</pre>";
            $idsArray = array();
            if(isset($formParams['update_invoice']) && count($formParams['update_invoice'])) {
                $idsArray = array_keys($formParams['update_invoice']);
                foreach ($idsArray as $id) {
                    $assigned_user_id = "";
                    if(isset($formParams['assigned_user_id'][$id]) && count($formParams['assigned_user_id'][$id])) {
                        $assigned_user_id = implode( ',', $formParams['assigned_user_id'][$id] );
                    }
                    $invoice = $this->_crmInvoice->create()->load($id);
                    $invoice->setData('assigned_user_id', $assigned_user_id);
                    $invoice->setId($id)->save();
                }
            }
        }
        echo 1;
    }
}
?>