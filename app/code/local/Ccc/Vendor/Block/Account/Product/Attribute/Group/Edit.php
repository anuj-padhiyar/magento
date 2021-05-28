<?php

class Ccc_Vendor_Block_Account_Product_Attribute_Group_Edit extends Mage_Core_Block_Template{
    public function __construct(){
        $this->_objectId = 'attribute_id';
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_product_group';
        parent::__construct();
    }

    public function getHeaderText(){
        if(Mage::registry('group')->getId()) {
            return Mage::helper('vendor')->__('Edit Product Attribute');
        }else{
            return Mage::helper('vendor')->__('New Product Attribute');
        }
    }

    public function getSaveUrl(){
        return $this->getUrl('*/*/save', array('_current'=>true, 'back'=>null));
    }

    public function getAttributes(){
        $groupId = Mage::getModel('vendor/product_attribute_group')
                        ->load($this->getRequest()->getParam('id'))
                        ->getAttributeGroupId();
        $readConnnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $ids = $readConnnection ->fetchAll(
                        "SELECT attribute_id 
                        FROM eav_entity_attribute 
                        WHERE attribute_group_id= $groupId");
        if($ids){
            return $ids;
        }
    }

    protected function getAttributeName($id){
        return Mage::getModel('vendor/attribute')->load($id)->getFrontendLabel();
	}
}
?>