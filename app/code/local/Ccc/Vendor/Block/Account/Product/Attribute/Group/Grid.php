<?php 

class Ccc_Vendor_Block_Account_Product_Attribute_Group_Grid extends Mage_Core_Block_Template
{	
	protected function _prepareCollection(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        return Mage::getResourceModel('vendor/product_attribute_group_collection')
            ->addFieldToFilter('vendor_id', array('like' => $vendorId .'%'));
	}

    


}