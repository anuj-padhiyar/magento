<?php 

class Ccc_Test_Block_Adminhtml_Test extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'test';
		$this->_controller = 'adminhtml_test';
		$this->_headerText = $this->__('Test Grid');
		$this->_addButtonLabel = $this->__('Add Test');
		parent::__construct();
	}
}

?>