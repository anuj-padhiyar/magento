<?php 

class Ccc_Seller_Block_Adminhtml_Seller extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_seller';
		$this->_blockGroup = 'seller';
		$this->_headerText = Mage::helper('seller')->__('Manage Seller');
		$this->_addButtonLabel = Mage::helper('seller')->__('Add Seller');
		parent::__construct();
	} 
}
?>