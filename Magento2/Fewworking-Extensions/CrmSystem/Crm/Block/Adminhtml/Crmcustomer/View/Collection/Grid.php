<?php
namespace Ueg\Crm\Block\Adminhtml\Crmcustomer\View\Collection;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

	protected $_coin;
    protected $_coinOptions;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,       
        \Ueg\Crm\Model\CoinFactory $CoinFactory,
        \Ueg\Crm\Model\Coinoptions $coinOptions,
        array $data = []
    ) {
        $this->_coin = $CoinFactory;
        $this->_coinOptions = $coinOptions;
        parent::__construct($context, $backendHelper, $data);
    }

    public function _construct()
	{
		parent::_construct();
		$this->setId('collectionGrid');
		$this->setDefaultSort('date_requested');
		$this->setDefaultDir('desc');

		$this->setUseAjax(true);
	}


	public function getGridUrl()
	{
		return $this->getUrl('crm/collection/grid', array('_current' => true, 'id' => $this->getRequest()->getParam('id')));
	}

	protected function _prepareCollection()
	{
		$collection = $this->_coin->create()->getCollection()
				->addFieldToFilter('coin_type', 2);
		$customerId = $this->getRequest()->getParam('id');
		if(isset($customerId) && !empty($customerId)) {
			$collection->addFieldToFilter('customer_id', $customerId);
		}
		$series = $this->getRequest()->getParam('series');
		if(isset($series) && !empty($series)) {
			$collection->addFieldToFilter('series_id', $series);
		}

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$coinOptions = $this->_coinOptions;

		$this->addColumn('coin_id', array(
			'header'    => __('ID'),
			'width'     => '50px',
			'index'     => 'coin_id',
			'type'  => 'number',
			'column_css_class'=>'no-display',
			'header_css_class'=>'no-display',
			'frame_callback' => array($this, 'callback_idfield'),
		));

		$this->addColumn(
			'pcgs',
			array(
				'header' => __('PCGS#'),
				'index' => 'pcgs',
				//'frame_callback' => array($this, 'callback_textfield'),
			)
		);

		$this->addColumn(
			'year',
			array(
				'header' => __('Year'),
				'index' => 'year',
				'frame_callback' => array($this, 'callback_textfield'),
			)
		);

		$mints = $coinOptions->getMintOptions();
		$mintOptions = array();
		foreach ($mints as $_mint) {
			$mintOptions[$_mint] = $_mint;
		}
		$this->addColumn(
			'mint',
			array(
				'header' => __('Mint'),
				'index' => 'mint',
				'type'      =>  'options',
				'options'   =>  $mintOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$this->addColumn(
			'variety',
			array(
				'header' => __('Variety'),
				'index' => 'variety',
				'frame_callback' => array($this, 'callback_textfield'),
			)
		);

		$desig = $coinOptions->getDesigOptions();
		$desigOptions = array();
		foreach ($desig as $_desig) {
			$desigOptions[$_desig] = $_desig;
		}
		$this->addColumn(
			'desig',
			array(
				'header' => __('Desig'),
				'index' => 'desig',
				'type'      =>  'options',
				'options'   =>  $desigOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$this->addColumn(
			'date_requested',
			array(
				'header' => __('Date Requested'),
				'index' => 'date_requested',
				'type'      => 'date',
				//'gmtoffset' => true,
				'frame_callback' => array($this, 'callback_datefield'),
			)
		);

		$service = $coinOptions->getServiceOptions();
		$serviceOptions = array();
		foreach ($service as $_service) {
			$serviceOptions[$_service] = $_service;
		}
		$this->addColumn(
			'service',
			array(
				'header' => __('Service'),
				'index' => 'service',
				'type'      =>  'options',
				'options'   =>  $serviceOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$grade = $coinOptions->getGradeOptions();
		$gradeOptions = array();
		foreach ($grade as $_grade) {
			$gradeOptions[$_grade] = $_grade;
		}
		$this->addColumn(
			'min_grade',
			array(
				'header' => __('Min Grade'),
				'index' => 'min_grade',
				'type'      =>  'options',
				'options'   =>  $gradeOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$this->addColumn(
			'max_grade',
			array(
				'header' => __('Max Grade'),
				'index' => 'max_grade',
				'type'      =>  'options',
				'options'   =>  $gradeOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$status = $coinOptions->getStatusOptions();
		$statusOptions = array();
		foreach ($status as $_status) {
			$statusOptions[$_status] = $_status;
		}
		$this->addColumn(
			'status',
			array(
				'header' => __('Status'),
				'index' => 'status',
				'type'      =>  'options',
				'options'   =>  $statusOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$this->addColumn(
			'note',
			array(
				'header' => __('Notes'),
				'index' => 'note',
				'frame_callback' => array($this, 'callback_textareafield'),
			)
		);

		$denom = $coinOptions->getDenomOptions();
		$denomOptions = array();
		foreach ($denom as $_denom) {
			$denomOptions[$_denom] = $_denom;
		}
		$this->addColumn(
			'denom',
			array(
				'header' => __('Denom'),
				'index' => 'denom',
				'type'      =>  'options',
				'options'   =>  $denomOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$type = $coinOptions->getTypeOptions();
		$typeOptions = array();
		foreach ($type as $_type) {
			$typeOptions[$_type] = $_type;
		}
		$this->addColumn(
			'type',
			array(
				'header' => __('Type'),
				'index' => 'type',
				'type'      =>  'options',
				'options'   =>  $typeOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$metal = $coinOptions->getMetalOptions();
		$metalOptions = array();
		foreach ($metal as $_metal) {
			$metalOptions[$_metal] = $_metal;
		}
		$this->addColumn(
			'metal',
			array(
				'header' => __('Metal'),
				'index' => 'metal',
				'type'      =>  'options',
				'options'   =>  $metalOptions,
				'frame_callback' => array($this, 'callback_selectfield'),
			)
		);

		$this->addColumn(
			'action',
			array(
				'header' => __('Action'),
				'index' => 'coin_id',
				'filter' => false,
				'sortable' => false,
				'frame_callback' => array($this, 'callback_actioncolumn'),
			)
		);


		return parent::_prepareColumns();
	}

	public function callback_idfield($value, $row, $column, $isExport)
	{
		$html = '';

		$id = $row->getId();
		$fieldName = $column->getIndex();
		$html .= '<input type="hidden" name="collection['.$id.']['.$fieldName.']" value="'.$value.'"/>';

		return $html;
	}

	public function callback_textfield($value, $row, $column, $isExport)
	{
		$html = '';

		$id = $row->getId();
		$fieldName = $column->getIndex();
		$html .= '<input type="text" name="collection['.$id.']['.$fieldName.']" class="text-box" value="'.$value.'"/>';

		return $html;
	}

	public function callback_textareafield($value, $row, $column, $isExport)
	{
		$html = '';

		$id = $row->getId();
		$fieldName = $column->getIndex();
		$html .= '<textarea name="collection['.$id.']['.$fieldName.']" class="textarea-box">'.$value.'</textarea>';

		return $html;
	}

	public function callback_selectfield($value, $row, $column, $isExport)
	{
		$html = '';

		$id = $row->getId();
		$fieldName = $column->getIndex();
		$options = $column->getOptions();

		$html .= "<select name='collection[$id][$fieldName]' class='select-box'>";
		$html .= "<option value=''></option>";
		foreach ($options as $option) {
			$selected = "";
			if($value == $option) {
				$selected = "selected='selected'";
			}
			$html .= "<option value='$option' $selected>$option</option>";
        }
        $html .= "</select>";

		return $html;
	}

	public function callback_actioncolumn($value, $row, $column, $isExport)
	{
		$html = '';

		$id = $row->getId();
		$html .= "<div style='width: 100px;'>";
		$html .= "<div><input type='checkbox' name='collection[$id][update]' value='1'/> Update</div>";
		$html .= "<div><input type='checkbox' name='collection[$id][delete]' value='1'/> Delete</div>";
		$html .= "</div>";

		return $html;
	}

	public function callback_datefield($value, $row, $column, $isExport)
	{
		$html = '';

		$id = $row->getId();
		$fieldName = $column->getIndex();
		$dateValue = ($value) ? date('m/j/y', strtotime($value)) : "";
		$html .= '<div class="range-collection"><input id="collection-request-date-'.$id.'" type="text" name="collection['.$id.']['.$fieldName.']" class="text-box" value="'. $dateValue .'"/></div>';
		//$html .= '<img style="margin: 0 0 0 5px;" title="Select Date" id="collection-date-trig-'.$id.'" alt="" src="'. $this->getSkinUrl("images/grid-cal.gif") .'"/>';
		 $html .= '<script>
                    require(["jquery","mage/calendar"],function($){
                    $("#collection-request-date-' . $id . '").calendar({
                         buttonText:"Select Date",dateFormat: "mm/dd/yy"
                    }); });
                 </script>';


		return $html;
	}

	public function getRowUrl($row) {
        return 'javascript:void(0)';
    }
}