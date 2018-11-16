<?php
namespace Ueg\Crm\Model\ResourceModel;

class Asr extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ueg_asr_customer_list', 'asr_id');
    }
}
?>