<?php
namespace Ueg\Crm\Model\ResourceModel;

class Crmadminacl extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('crmadminacl', 'crmacl_id');
    }
}
?>