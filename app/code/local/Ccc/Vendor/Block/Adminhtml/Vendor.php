<?php 

class Ccc_Vendor_Block_Adminhtml_Vendor extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'vendor';
		$this->_controller = 'adminhtml_vendor';
		$this->_addButtonLabel = $this->__('Add Vendor');
		$this->_headerText = $this->__('Vendor Grid');
	}
}

?>