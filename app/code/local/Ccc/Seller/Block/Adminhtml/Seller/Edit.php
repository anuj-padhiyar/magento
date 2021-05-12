<?php 

class Ccc_Seller_Block_Adminhtml_Seller_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		$this->_blockGroup = 'seller';
		$this->_controller = 'adminhtml_seller';
		$this->_updateButton('save','label',Mage::helper('seller')->__('Save Seller'));
		$this->_updateButton('delete','label',Mage::helper('seller')->__('Delete Seller'));
	}

	public function getHeaderText()
	{
		if(Mage::registry('seller_data') && Mage::registry('seller_data')->getId())
		{
			return Mage::helper('seller')->__("Edit Seller");//,$this->htmlEscape(Mage::registry('seller_data')->getTitle()));
		}
		else
		{
			return Mage::helper('seller')->__("Add Seller");
		}
	}
}
?>