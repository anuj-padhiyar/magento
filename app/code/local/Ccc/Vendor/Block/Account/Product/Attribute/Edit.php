<?php

class Ccc_Vendor_Block_Account_Product_Attribute_Edit extends Mage_Core_Block_Template{
    public function __construct(){
        $this->_objectId = 'attribute_id';
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_product_attribute';
        parent::__construct();
    }

    public function getHeaderText(){
        if(Mage::registry('product_attribute')->getId()) {
            return Mage::helper('vendor')->__('Edit Product Attribute');
        }else{
            return Mage::helper('vendor')->__('New Product Attribute');
        }
    }

    public function getSaveUrl(){
        return $this->getUrl('*/'.$this->_controller.'/save', array('_current'=>true, 'back'=>null));
    }

    public function getValue($key,$attr){
        if($attr->$key){
            return $attr->$key;
        }
        return null;
    }   

    public function getGroups(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        return Mage::getResourceModel('vendor/product_attribute_group_collection')->addFieldToFilter('vendor_id',['like'=>$vendorId]);
    }

    public function getCurrentGroup(){
        if($attributeId = $this->getRequest()->getParam('id')){
            $setId = Mage::getModel('eav/entity_setup', 'core_setup')->getAttributeSetId('vendor_product', 'Default');
            $readConnnection = Mage::getSingleton('core/resource')->getConnection('core_read');
            $id = $readConnnection 
                    ->fetchRow(
                            "SELECT attribute_group_id 
                            FROM eav_entity_attribute 
                            WHERE attribute_id = $attributeId 
                            AND attribute_set_id = $setId");
            return $id['attribute_group_id'];
        }
        return null;
    }
}
?>