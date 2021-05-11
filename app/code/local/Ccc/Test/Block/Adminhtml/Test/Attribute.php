<?php

class Ccc_Test_Block_Adminhtml_Test_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'test';
		$this->_controller = 'adminhtml_test_attribute';
		$this->_headerText = Mage::helper('test')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('test')->__('Add New Attribute');
		parent::__construct();
	}
}

?>