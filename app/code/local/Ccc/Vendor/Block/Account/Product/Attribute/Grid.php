<?php 

class Ccc_Vendor_Block_Account_Product_Attribute_Grid extends Mage_Core_Block_Template
{	
	protected function _prepareCollection(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        return Mage::getResourceModel('vendor/product_attribute_collection')
            ->addFieldToFilter('attribute_code', array('like' => $vendorId .'%'));
	}

    public function getGroupAttributes($id){
        $readConnnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $id = $readConnnection ->fetchRow(
                        "SELECT attribute_id 
                        FROM eav_entity_attribute 
                        WHERE attribute_id= $id");
        if($id && array_key_exists('attribute_id',$id)){
            return 1;
        }
        return 0;
    }
}